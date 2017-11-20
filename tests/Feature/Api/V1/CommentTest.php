<?php

namespace Tests\Feature\Api\V1;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testCommentIndex()
    {
        $comments = factory(Comment::class, 10)->create();

        $this->json('GET', '/api/v1/comments')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'content',
                    'posted_at',
                    'author_id',
                    'post_id'
                ]],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ]
            ]);
    }

    public function testUsersComments()
    {
        $user = factory(User::class)->create();
        $comments = factory(Comment::class, 10)->create(['author_id' => $user->id]);
        $randomComments = factory(Comment::class, 10)->create();

        $this->json('GET', "/api/v1/users/{$user->id}/comments")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'content',
                    'posted_at',
                    'author_id',
                    'post_id',
                ]],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ]
            ])
            ->assertJsonFragment([
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => 20,
                'to' => 10,
                'total' => 10
            ]);
    }

    public function testPostsComments()
    {
        $post = factory(Post::class)->create();
        $comments = factory(Comment::class, 10)->create(['post_id' => $post->id]);
        $randomComments = factory(Comment::class, 10)->create();

        $this->json('GET', "/api/v1/posts/{$post->id}/comments")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'content',
                    'posted_at',
                    'author_id',
                    'post_id',
                ]],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ]
            ])
            ->assertJsonFragment([
                'current_page' => 1,
                'from' => 1,
                'last_page' => 1,
                'per_page' => 20,
                'to' => 10,
                'total' => 10
            ]);
    }

    public function testStore()
    {
        $post = factory(Post::class)->create();

        $response = $this->actingAs($this->user(), 'api')
                         ->json('POST', "/api/v1/posts/{$post->id}/comments", $this->validParams());

        $response->assertStatus(201);
    }

    public function testStoreFail()
    {
        $response = $this->actingAs($this->user(), 'api')
                         ->json('POST', "/api/v1/posts/31415/comments", $this->validParams());

        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'No query results for model [App\\Post].'
            ]);
    }

    public function testCommentShow()
    {
        $comment = factory(Comment::class)->create([
            'content' => 'The Empire Strikes Back'
        ]);

        $this->json('GET', "/api/v1/comments/{$comment->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'content',
                    'posted_at',
                    'humanized_posted_at',
                    'author_id',
                    'post_id',
                    'author_name',
                    'author_url',
                    'can_delete',
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $comment->id,
                    'content' => 'The Empire Strikes Back',
                    'posted_at' => $comment->posted_at->toIso8601String(),
                    'author_id' => $comment->author_id,
                    'post_id' => $comment->post_id,
                    'author_name' => $comment->author->name,
                    'can_delete' => false
                ],
            ]);
    }

    public function testCommentShowFail()
    {
        $this->json('GET', '/api/v1/comments/31415')
            ->assertStatus(404)
            ->assertJson([
                'message' => 'No query results for model [App\\Comment].'
            ]);
    }

    public function testCommentDelete()
    {
        $comment = factory(Comment::class)->create();

        $this->actingAs($comment->author, 'api')
            ->json('DELETE', "/api/v1/comments/{$comment->id}")
            ->assertStatus(204);
    }

    public function testCommentDeleteNotFound()
    {
        $this->actingAs($this->user(), 'api')
            ->json('DELETE', '/api/v1/comments/31415')
            ->assertStatus(404)
            ->assertJson([
                'message' => 'No query results for model [App\\Comment].'
            ]);
    }

    public function testCommentDeleteUnauthorized()
    {
        $comment = factory(Comment::class)->create();

        $this->actingAs($this->user(), 'api')
            ->json('DELETE', "/api/v1/comments/{$comment->id}")
            ->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }

    public function testCommentsDeleteUnauthenticated()
    {
        $comment = factory(Comment::class)->create();
        $this->json('DELETE', "/api/v1/comments/{$comment->id}")
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
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
            'content' => 'Star Trek ?',
        ], $overrides);
    }
}
