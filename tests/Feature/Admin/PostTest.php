<?php

namespace Tests\Feature\Admin;

use App\Models\Comment;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        factory(Post::class)->create(['author_id' => $anakin->id]);
        factory(Post::class, 3)->create();

        $this->actingAsAdmin()
            ->get("/admin/posts")
            ->assertStatus(200)
            ->assertSee('4 posts')
            ->assertSee('Anakin')
            ->assertSee('Author')
            ->assertSee('Posted at')
            ->assertSee('Title');
    }

    public function testCreate()
    {
        $this->actingAsAdmin()
            ->get('/admin/posts/create')
            ->assertStatus(200)
            ->assertSee('Create post')
            ->assertSee('Title')
            ->assertSee('Author')
            ->assertSee('Posted at')
            ->assertSee('Content')
            ->assertSee('Save');
    }

    public function testStore()
    {
        $params = $this->validParams();

        $this->actingAsAdmin()
            ->post('/admin/posts', $params)
            ->assertStatus(302);

        $params['posted_at'] = now()->second(0)->toDateTimeString();

        $post = Post::first();

        $this->assertDatabaseHas('posts', $params);
    }

    public function testStoreFail()
    {
        $params = $this->validParams(['content' => null]);

        $this->actingAsAdmin()
            ->post('/admin/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
    }

    public function testEdit()
    {
        $anakin = $this->admin(['name' => 'Anakin', 'email' => 'anakin@skywalker.st']);
        $post = factory(Post::class)->create(['author_id' => $anakin->id]);

        $this->actingAs($anakin)
            ->get("/admin/posts/{$post->slug}/edit")
            ->assertStatus(200)
            ->assertSee('Anakin')
            ->assertSee('Show post')
            ->assertSee(e($post->title))
            ->assertSee(e($post->content))
            ->assertSee(humanize_date($post->posted_at, 'Y-m-d\TH:i'))
            ->assertSee('Update')
            ->assertSee('Posted at');
    }

    public function testUpdate()
    {
        $post = factory(Post::class)->create();
        $params = $this->validParams();

        $response = $this->actingAsAdmin()->patch("/admin/posts/{$post->slug}", $params);

        $post->refresh();

        $response->assertRedirect("/admin/posts/{$post->slug}/edit");

        $this->assertDatabaseHas('posts', $params);
        $this->assertEquals($params['content'], $post->content);
    }

    public function testDelete()
    {
        $post = factory(Post::class)->create();
        factory(Comment::class, 2)
            ->create()
            ->each(function ($comment) use ($post) {
                $comment->post_id = $post->id;
                $comment->save();
            });

        $this->actingAsAdmin()
            ->delete("/admin/posts/{$post->slug}")
            ->assertStatus(302);

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
            'posted_at' => now()->format('Y-m-d\TH:i'),
            'author_id' => $this->admin()->id,
        ], $overrides);
    }
}
