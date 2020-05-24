<?php

namespace Tests\Feature\Api\V1;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testCommentIndex()
    {
        factory(Comment::class, 2)->create();

        $this->json('GET', '/api/v1/comments')
            ->assertOk()
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
        factory(Comment::class, 10)->create(['author_id' => $user->id]);
        factory(Comment::class, 10)->create();

        $this->json('GET', "/api/v1/users/{$user->id}/comments")
            ->assertOk()
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
        factory(Comment::class, 10)->create(['post_id' => $post->id]);
        factory(Comment::class, 10)->create();

        $this->json('GET', "/api/v1/posts/{$post->id}/comments")
            ->assertOk()
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

        $this->actingAsUser('api')
            ->json('POST', "/api/v1/posts/{$post->id}/comments", $this->validParams())
            ->assertCreated();
    }

    public function testStoreFail()
    {
        $this->actingAsUser('api')
            ->json('POST', "/api/v1/posts/31415/comments", $this->validParams())
            ->assertNotFound()
            ->assertJson([
                'message' => 'No query results for model [App\\Models\\Post] 31415'
            ]);
    }

    public function testCommentShow()
    {
        $comment = factory(Comment::class)->create([
            'content' => 'The Empire Strikes Back'
        ]);

        $this->json('GET', "/api/v1/comments/{$comment->id}")
            ->assertOk()
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
            ->assertNotFound()
            ->assertJson([
                'message' => 'No query results for model [App\\Models\\Comment] 31415'
            ]);
    }

    public function testCommentDelete()
    {
        $comment = factory(Comment::class)->create();

        $this->actingAs($comment->author, 'api')
            ->json('DELETE', "/api/v1/comments/{$comment->id}")
            ->assertNoContent();
    }

    public function testCommentDeleteNotFound()
    {
        $this->actingAsUser('api')
            ->json('DELETE', '/api/v1/comments/31415')
            ->assertNotFound()
            ->assertJson([
                'message' => 'No query results for model [App\\Models\\Comment] 31415'
            ]);
    }

    public function testCommentDeleteUnauthorized()
    {
        $comment = factory(Comment::class)->create();

        $this->actingAsUser('api')
            ->json('DELETE', "/api/v1/comments/{$comment->id}")
            ->assertForbidden()
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }

    public function testCommentsDeleteUnauthenticated()
    {
        $comment = factory(Comment::class)->create();
        $this->json('DELETE', "/api/v1/comments/{$comment->id}")
            ->assertUnauthorized()
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
