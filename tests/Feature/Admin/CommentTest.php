<?php

namespace Tests\Feature\Admin;

use App\Comment;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        $comment = factory(Comment::class)->create(['author_id' => $anakin->id]);

        $this->actingAsAdmin()
            ->get('/admin/comments')
            ->assertStatus(200)
            ->assertSee('1 comment')
            ->assertSee('Anakin')
            ->assertSee('Content')
            ->assertSee('Author')
            ->assertSee('Posted at')
            ->assertSee(e(str_limit($comment->content, 50)));
    }

    public function testEdit()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        $comment = factory(Comment::class)->create(['author_id' => $anakin->id]);

        $this->actingAsAdmin()
            ->get("/admin/comments/{$comment->id}/edit")
            ->assertStatus(200)
            ->assertSee('Anakin')
            ->assertSee('Show post :')
            ->assertSee(route('posts.show', $comment->post))
            ->assertSee('Content')
            ->assertSee(e($comment->content))
            ->assertSee('Posted at')
            ->assertSee(humanize_date($comment->posted_at, 'Y-m-d\TH:i'))
            ->assertSee('Update')
            ->assertSee('Delete');
    }

    public function testUpdate()
    {
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create(['post_id' => $post->id]);
        $params = $this->validParams([
            'post_id' => $post->id,
            'posted_at' => $post->posted_at->addDay()->format('Y-m-d\TH:i')
        ]);

        $this->actingAsAdmin()
            ->patch("/admin/comments/{$comment->id}", $params)
            ->assertRedirect("/admin/comments/{$comment->id}/edit");

        $comment->refresh();
        $this->assertDatabaseHas('comments', $params);
        $this->assertEquals($params['content'], $comment->content);
    }

    public function testUpdateFail()
    {
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create(['post_id' => $post->id]);
        $params = $this->validParams([
            'post_id' => $post->id,
            'posted_at' => $post->posted_at->subDay()->format('Y-m-d\TH:i')
        ]);

        $this->actingAsAdmin()
            ->patch("/admin/comments/{$comment->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $comment->refresh();
        $this->assertDatabaseMissing('comments', $params);
    }

    public function testDelete()
    {
        $comment = factory(Comment::class)->create();

        $this->actingAsAdmin()
            ->delete("/admin/comments/{$comment->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('comments', $comment->toArray());
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
        $post = factory(Post::class)->create();

        return array_merge([
            'content' => "Great article ! Thanks for sharing it with us.",
            'posted_at' => $post->posted_at->addDay()->format('Y-m-d\TH:i'),
            'post_id' => $post->id,
            'author_id' => factory(User::class)->create()->id,
        ], $overrides);
    }
}
