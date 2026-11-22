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

    public function test_comment_index()
    {
        Comment::factory()->count(2)->create();

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

    public function test_users_comments()
    {
        $user = User::factory()->create();
        Comment::factory()->count(10)->create(['author_id' => $user->id]);
        Comment::factory()->count(10)->create();

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

    public function test_posts_comments()
    {
        $post = Post::factory()->create();
        Comment::factory()->count(10)->create(['post_id' => $post->id]);
        Comment::factory()->count(10)->create();

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

    public function test_store()
    {
        $post = Post::factory()->create();

        $this->actingAsUser('sanctum')
            ->json('POST', "/api/v1/posts/{$post->id}/comments", $this->validParams())
            ->assertCreated();
    }

    public function test_store_fail()
    {
        $this->actingAsUser('sanctum')
            ->json('POST', '/api/v1/posts/31415/comments', $this->validParams())
            ->assertNotFound()
            ->assertJson([
                'message' => sprintf('No query results for model [%s] 31415', Post::class)
            ]);
    }

    public function test_comment_show()
    {
        $comment = Comment::factory()->create([
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

    public function test_comment_show_fail()
    {
        $this->json('GET', '/api/v1/comments/31415')
            ->assertNotFound()
            ->assertJson([
                'message' => sprintf('No query results for model [%s] 31415', Comment::class)
            ]);
    }

    public function test_comment_delete()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->author, 'sanctum')
            ->json('DELETE', "/api/v1/comments/{$comment->id}")
            ->assertNoContent();
    }

    public function test_comment_delete_not_found()
    {
        $this->actingAsUser('sanctum')
            ->json('DELETE', '/api/v1/comments/31415')
            ->assertNotFound()
            ->assertJson([
                'message' => sprintf('No query results for model [%s] 31415', Comment::class)
            ]);
    }

    public function test_comment_delete_unauthorized()
    {
        $comment = Comment::factory()->create();

        $this->actingAsUser('sanctum')
            ->json('DELETE', "/api/v1/comments/{$comment->id}")
            ->assertForbidden()
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }

    public function test_comments_delete_unauthenticated()
    {
        $comment = Comment::factory()->create();
        $this->json('DELETE', "/api/v1/comments/{$comment->id}")
            ->assertUnauthorized()
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    /**
     * Valid params for updating or creating a resource
     */
    private function validParams(array $overrides = []): array
    {
        return array_merge([
            'content' => 'Star Trek ?',
        ], $overrides);
    }
}
