<?php

namespace Tests\Feature\Admin;

use App\Comment;

use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        $post = factory(Post::class)->create(['author_id' => $anakin->id]);
        $posts = factory(Post::class, 24)->create();

        $response = $this->actingAs($this->admin())->get("/admin/posts");

        $response->assertStatus(200)
                 ->assertSee('25 articles')
                 ->assertSee('Anakin')
                 ->assertSee('Auteur')
                 ->assertSee('Posté le')
                 ->assertSee('Titre');
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->admin())->get('/admin/posts/create');

        $response->assertStatus(200)
               ->assertSee('Ajouter un article')
               ->assertSee('Titre')
               ->assertSee('Auteur')
               ->assertSee('Post&eacute; le')
               ->assertSee('Contenu')
               ->assertSee('Sauvegarder');
    }

    public function testStore()
    {
        $params = $this->validParams();

        $response = $this->actingAs($this->admin())->post('/admin/posts', $params);
        $params['posted_at'] = Carbon::now()->second(0)->toDateTimeString();

        $post = Post::first();

        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', array_except($params, ['thumbnail']));
        $this->assertTrue($post->hasThumbnail());
        $this->assertTrue(Storage::disk('local')->exists($post->thumbnail()->filename));
        $this->assertEquals($post->thumbnail()->original_filename, 'file.png');

        Storage::delete($post->thumbnail()->filename);
    }

    public function testStoreFail()
    {
        $params = $this->validParams(['content' => null]);

        $response = $this->actingAs($this->admin())->post('/admin/posts', $params);

        $response->assertStatus(302)
                 ->assertSessionHas('errors');
    }

    public function testEdit()
    {
        $anakin = $this->admin(['name' => 'Anakin', 'email' => 'anakin@skywalker.st']);
        $post = factory(Post::class)->create(['author_id' => $anakin->id]);

        $response = $this->actingAs($this->admin())->get("/admin/posts/{$post->slug}/edit");

        $response->assertStatus(200)
                 ->assertSee('Anakin')
                 ->assertSee('Voir l&#039;article')
                 ->assertSee(e($post->title))
                 ->assertSee(e($post->content))
                 ->assertSee(humanize_date($post->posted_at, 'Y-m-d\TH:i'))
                 ->assertSee('Mettre à jour')
                 ->assertSee('Post&eacute; le');
    }

    public function testUpdate()
    {
        $post = factory(Post::class)->create();
        $params = $this->validParams();

        $response = $this->actingAs($this->admin())
                         ->patch("/admin/posts/{$post->slug}", $params);

        $post->refresh();

        $response->assertStatus(302);
        $response->assertRedirect("/admin/posts/{$post->slug}/edit");
        $this->assertDatabaseHas('posts', array_except($params, 'thumbnail'));
        $this->assertTrue($post->hasThumbnail());
        $this->assertEquals($params['content'], $post->content);

        Storage::delete($post->thumbnail()->filename);
    }

    public function testUnsetThumbnail()
    {
        $post = factory(Post::class)->create();
        $post->storeAndSetThumbnail(UploadedFile::fake()->image('file.png'));
        $thumbnail = $post->thumbnail();

        $response = $this->actingAs($this->admin())->delete("/admin/posts/{$post->slug}/thumbnail", []);

        $post->refresh();

        $response->assertStatus(302);
        $response->assertRedirect("/admin/posts/{$post->slug}/edit");
        $this->assertFalse($post->hasThumbnail());

        Storage::delete($thumbnail->filename);
    }

    public function testDelete()
    {
        $post = factory(Post::class)->create();
        $comments = factory(Comment::class, 5)
                    ->create()
                    ->each(function ($comment) use ($post) {
                        $comment->post_id = $post->id;
                        $comment->save();
                    });

        $response = $this->actingAs($this->admin())->delete("/admin/posts/{$post->slug}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('posts', $post->toArray());
        $this->assertTrue(Comment::all()->isEmpty());
    }

    /**
     * Valid params for updating or creating a resource
     *
     * @param  array $overrides new params
     * @return array Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'hello world',
            'content' => "I'm a content",
            'posted_at' => Carbon::now()->format('Y-m-d\TH:i'),
            'author_id' => $this->admin()->id,
            'thumbnail' => UploadedFile::fake()->image('file.png'),
        ], $overrides);
    }
}
