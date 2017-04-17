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
}
