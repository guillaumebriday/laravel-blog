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

        $posts = factory(Post::class, 10)->create();
        $post = factory(Post::class)->create(['author_id' => $anakin->id]);
        $comments = factory(Comment::class, 3)->create(['post_id' => $post->id]);

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Les derniers articles')
            ->assertSee(e($post->content))
            ->assertSee(e($post->title))
            ->assertSee(humanize_date($post->posted_at))
            ->assertSee('3')
            ->assertSee('Anakin');
    }

    public function testSearch()
    {
        factory(Post::class, 10)->create();
        $post = factory(Post::class)->create(['title' => 'Hello Obiwan']);

        $this->get('/?q=Hello')
            ->assertStatus(200)
            ->assertSee('1 article trouvé')
            ->assertSee(e($post->content))
            ->assertSee(e($post->title))
            ->assertSee(humanize_date($post->posted_at));
    }

    public function testShow()
    {
        $post = factory(Post::class)->create();
        $comments = factory(Comment::class, 9)->create(['post_id' => $post->id]);
        $comment = factory(Comment::class)->create(['post_id' => $post->id]);

        $this->actingAs($this->user())
            ->get("/posts/{$post->slug}")
            ->assertStatus(200)
            ->assertSee(e($post->content))
            ->assertSee(e($post->title))
            ->assertSee(humanize_date($post->posted_at))
            ->assertSee('10 commentaires')
            ->assertSee('Commenter');
    }

    public function testShowUnauthenticated()
    {
        $post = factory(Post::class)->create();

        $this->get("/posts/{$post->slug}")
            ->assertStatus(200)
            ->assertSee('Vous devez vous connecter pour commenter.');
    }
}
