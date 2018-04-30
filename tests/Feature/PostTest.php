<?php

namespace Tests\Feature;

use App\Comment;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $anakin = factory(User::class)->states('anakin')->create();

        $post = factory(Post::class)->create(['author_id' => $anakin->id]);
        factory(Post::class, 2)->create();
        factory(Comment::class, 3)->create(['post_id' => $post->id]);

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Latest posts')
            ->assertSee(e($post->content))
            ->assertSee(e($post->title))
            ->assertSee(humanize_date($post->posted_at))
            ->assertSee('3')
            ->assertSee('Anakin');
    }

    public function testSearch()
    {
        factory(Post::class, 3)->create();
        $post = factory(Post::class)->create(['title' => 'Hello Obiwan']);

        $this->get('/?q=Hello')
            ->assertStatus(200)
            ->assertSee('1 post found')
            ->assertSee(e($post->content))
            ->assertSee(e($post->title))
            ->assertSee(humanize_date($post->posted_at));
    }

    public function testShow()
    {
        $post = factory(Post::class)->create();
        factory(Comment::class, 2)->create(['post_id' => $post->id]);
        factory(Comment::class)->create(['post_id' => $post->id]);

        $this->actingAsUser()
            ->get("/posts/{$post->slug}")
            ->assertStatus(200)
            ->assertSee(e($post->content))
            ->assertSee(e($post->title))
            ->assertSee(humanize_date($post->posted_at))
            ->assertSee('3 comments')
            ->assertSee('Comment');
    }

    public function testShowUnauthenticated()
    {
        $post = factory(Post::class)->create();

        $this->get("/posts/{$post->slug}")
            ->assertStatus(200)
            ->assertSee('You must be signed in to comment.');
    }
}
