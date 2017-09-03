<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Post;
use App\Role;
use App\Comment;
use Carbon\Carbon;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it renders admin posts index view
     * @return void
     */
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

    /**
     * it renders admin posts edit view
     * @return void
     */
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
                 ->assertSee('Mettre &agrave; jour')
                 ->assertSee('Post&eacute; le');
    }

    /**
     * it updates requested post in admin dashboard
     * @return void
     */
    public function testUpdate()
    {
        $post = factory(Post::class)->create();
        $params = $this->validParams();

        $response = $this->actingAs($this->admin())
                         ->patch("/admin/posts/{$post->slug}", $params);

        $post = $post->fresh();

        $response->assertStatus(302);
        $response->assertRedirect("/admin/posts/{$post->slug}/edit");
        $this->assertDatabaseHas('posts', $params);
        $this->assertEquals($params['content'], $post->content);
    }

    /**
     * it deletes requested post in admin dashboard
     * @return void
     */
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
     * @param  array $overrides new params
     * @return array Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'hello world',
            'content' => "I'm a content",
            'posted_at' => Carbon::yesterday()->format('Y-m-d\TH:i'),
            'author_id' => $this->admin()->id,
        ], $overrides);
    }
}
