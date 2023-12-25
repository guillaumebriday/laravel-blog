<?php

namespace Tests\Feature\Admin;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $anakin = User::factory()->anakin()->create();
        $comment = Comment::factory()->create(['author_id' => $anakin->id]);

        $this->actingAsAdmin()
            ->get('/admin/comments')
            ->assertOk()
            ->assertSee('1 comment')
            ->assertSee('Anakin')
            ->assertSee('Content')
            ->assertSee('Author')
            ->assertSee('Posted at')
            ->assertSee(Str::limit($comment->content, 50));
    }

    public function testEdit()
    {
        $anakin = User::factory()->anakin()->create();
        $comment = Comment::factory()->create(['author_id' => $anakin->id]);

        $this->actingAsAdmin()
            ->get("/admin/comments/{$comment->id}/edit")
            ->assertOk()
            ->assertSee('Anakin')
            ->assertSee('Show post :')
            ->assertSee(route('posts.show', $comment->post))
            ->assertSee('Content')
            ->assertSee($comment->content)
            ->assertSee('Posted at')
            ->assertSee(humanize_date($comment->posted_at, 'Y-m-d\TH:i'))
            ->assertSee('Update');
    }

    public function testUpdate()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        $params = $this->validParams([
            'post_id' => $post->id,
            'posted_at' => $post->posted_at->addDay()->format('Y-m-d\TH:i')
        ]);

        $this->actingAsAdmin()
            ->patch("/admin/comments/{$comment->id}", $params)
            ->assertRedirect("/admin/comments/{$comment->id}/edit");

        $this->assertDatabaseHas('comments', $params);
        $this->assertEquals($params['content'], $comment->refresh()->content);
    }

    public function testUpdateFail()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id]);
        $params = $this->validParams([
            'post_id' => $post->id,
            'posted_at' => $post->posted_at->subDay()->format('Y-m-d\TH:i')
        ]);

        $this->actingAsAdmin()
            ->patch("/admin/comments/{$comment->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $this->assertDatabaseMissing('comments', $params);
    }

    public function testDelete()
    {
        $comment = Comment::factory()->create();

        $this->actingAsAdmin()
            ->delete("/admin/comments/{$comment->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('comments', $comment->toArray());
        $this->assertTrue(Comment::all()->isEmpty());
    }

    /**
     * Valid params for updating or creating a resource
     */
    private function validParams(array $overrides = []): array
    {
        $post = Post::factory()->create();

        return array_merge([
            'content' => 'Great article ! Thanks for sharing it with us.',
            'posted_at' => $post->posted_at->addDay()->format('Y-m-d\TH:i'),
            'post_id' => $post->id,
            'author_id' => User::factory()->create()->id,
        ], $overrides);
    }
}
