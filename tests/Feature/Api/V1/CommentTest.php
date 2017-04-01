<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;
use App\Comment;
use App\Role;
use Carbon\Carbon;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it returns a comments collection
     * @return void
     */
    public function testCommentIndex()
    {
        $comments = factory(Comment::class, 10)->create();
        $response = $this->actingAs($this->user(), 'api')->json('GET', '/api/v1/comments');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'type',
                    'id',
                    'attributes' => [
                        'content',
                        'posted_at',
                        'author_id',
                        'post_id'
                    ]
                ]],
                'meta' => [
                    'pagination' => [
                        'total'
                    ]
                ],
                'links' => [
                    'self',
                    'first',
                    'last'
                ]
            ]);
    }

    /**
     * it returns a comment item
     * @return void
     */
    public function testCommentShow()
    {
        $comment = factory(Comment::class)->create([
            'content' => 'The Empire Strikes Back'
        ]);

        $response = $this->actingAs($this->user(), 'api')->json('GET', "/api/v1/comments/{$comment->id}");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'content',
                        'posted_at',
                        'author_id',
                        'post_id',
                    ]
                ],
            ])
            ->assertJson([
                'data' => [
                    'type' => 'comments',
                    'id' => $comment->id,
                    'attributes' => [
                        'content' => 'The Empire Strikes Back',
                        'posted_at' => $comment->posted_at->toIso8601String(),
                        'author_id' => $comment->author_id,
                        'post_id' => $comment->post_id
                    ]
                ],
            ]);
    }

    /**
     * it returns a 404 not found error
     * @return void
     */
    public function testCommentShowFail()
    {
        $response = $this->actingAs($this->user(), 'api')->json('GET', '/api/v1/comments/31415');

        $response
            ->assertStatus(404)
            ->assertJson([
                'error' => [
                    'message' => 'Not found.',
                    'status' => 404
                ]
            ]);
    }

    /**
     * it deletes requested comment
     * @return void
     */
    public function testCommentDelete()
    {
        $comment = factory(Comment::class)->create();

        $response = $this->actingAs($comment->author, 'api')->json('DELETE', "/api/v1/comments/{$comment->id}");

        $response->assertStatus(204);
    }

    /**
     * it returns a 404 not found error
     * @return void
     */
    public function testCommentDeleteNotFound()
    {
        $response = $this->actingAs($this->user(), 'api')->json('DELETE', '/api/v1/comments/31415');

        $response
            ->assertStatus(404)
            ->assertJson([
                'error' => [
                    'message' => 'Not found.',
                    'status' => 404
                ]
            ]);
    }

    /**
     * it returns a 401 unauthorized error
     * @return void
     */
    public function testCommentDeleteUnauthorized()
    {
        $comment = factory(Comment::class)->create();

        $response = $this->actingAs($this->user(), 'api')->json('DELETE', "/api/v1/comments/{$comment->id}");

        $response
            ->assertStatus(401)
            ->assertJson([
                'error' => [
                    'message' => 'Unauthorized.',
                    'status' => 401
                ]
            ]);
    }
}
