<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Comment;
use App\User;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it renders posts index view
     * @return void
     */
    public function testIndex()
    {
        $user = $this->user();
        $anakin = factory(User::class)->states('anakin')->create();

        $posts = factory(Post::class, 10)->create();
        $post = factory(Post::class)->create(['author_id' => $anakin->id]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200)
                 ->assertSee('Les derniers articles')
                 ->assertSee(e($post->content))
                 ->assertSee(e($post->title))
                 ->assertSee(humanize_date($post->posted_at))
                 ->assertSee('Anakin');
    }

    /**
     * it renders a post show view
     * @return void
     */
    public function testShow()
    {
        $user = $this->user();
        $post = factory(Post::class)->create();
        $comments = factory(Comment::class, 9)->create(['post_id' => $post->id]);
        $comment = factory(Comment::class)->create(['post_id' => $post->id]);

        $response = $this->actingAs($user)->get("/posts/{$post->slug}");

        $response->assertStatus(200)
                 ->assertSee(e($post->content))
                 ->assertSee(e($post->title))
                 ->assertSee(humanize_date($post->posted_at))
                 ->assertSee('10 commentaires')
                 ->assertSee('Ajouter un commentaire')
                 ->assertSee('Commenter')
                 ->assertSee(e($comment->content));
    }

    /**
     * it renders a post create view
     * @return void
     */
    public function testCreate()
    {
        $user = $this->user();

        $response = $this->actingAs($user)->get('/posts/create');

        $response->assertStatus(200)
                 ->assertSee('Ajouter un article')
                 ->assertSee('Titre')
                 ->assertSee('Contenu')
                 ->assertSee('Publier');
    }

    /**
     * it renders a post edit view
     * @return void
     */
    public function testEdit()
    {
        $post = factory(Post::class)->create();
        $response = $this->actingAs($post->author)->get("/posts/{$post->slug}/edit");

        $response->assertStatus(200)
                 ->assertSee('Éditer un article')
                 ->assertSee('Titre')
                 ->assertSee($post->title)
                 ->assertSee('Contenu')
                 ->assertSee($post->content)
                 ->assertSee('Publier');
    }

    /**
     * it updates the post
     * @return void
     */
    public function testUpdate()
    {
        $post = factory(Post::class)->create();
        $params = $this->validParams();

        $response = $this->actingAs($post->author)->patch("/posts/{$post->slug}", $params);

        $post = $post->fresh();

        $response->assertStatus(302);
        $response->assertRedirect("/posts/{$post->slug}");
        $this->assertDatabaseHas('posts', array_except($params, 'thumbnail'));
        $this->assertEquals($params['title'], $post->title);
        $this->assertEquals($params['content'], $post->content);

        Storage::delete($post->thumbnail()->filename);
    }

    /**
     * it unsets the post's thumnbail
     * @return void
     */
    public function testUnsetThumbnail()
    {
        $post = factory(Post::class)->create();

        $response = $this->actingAs($post->author)->delete("/posts/{$post->slug}/thumbnail", []);

        $post = $post->fresh();

        $response->assertStatus(302);
        $response->assertRedirect("/posts/{$post->slug}/edit");
        $this->assertFalse($post->hasThumbnail());
    }

    /**
     * it stores a new post
     * @return void
     */
    public function testStore()
    {
        $user = $this->user();
        $params = $this->validParams();

        $response = $this->actingAs($user)->post('/posts', $params);

        $params = array_except($params, ['thumbnail']);
        $post = Post::first();

        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', $params);
        $this->assertTrue($post->hasThumbnail());
        $this->assertTrue(Storage::disk('local')->exists($post->thumbnail()->filename));
        $this->assertEquals($post->thumbnail()->original_filename, 'file.png');

        Storage::delete($post->thumbnail()->filename);
    }

    /**
     * it returns errors when param's missing
     * @return void
     */
    public function testStoreFail()
    {
        $user = $this->user();
        $params = $this->validParams([
            'content' => null
        ]);

        $response = $this->actingAs($user)->post('/posts', $params);

        $response->assertStatus(302)
                 ->assertSessionHas('errors');
    }

    /**
     * Valid params for updating or creating a resource
     * @param  array  $overrides new params
     * @return array  Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Star Trek ?',
            'content' => 'Star Wars.',
            'thumbnail' => UploadedFile::fake()->image('file.png')
        ], $overrides);
    }
}
