<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

test('comment index', function (): void {
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
});

test('users comments', function (): void {
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
});

test('posts comments', function (): void {
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
});

test('store', function (): void {
    $post = Post::factory()->create();

    $this->actingAsUser('sanctum')
        ->json('POST', "/api/v1/posts/{$post->id}/comments", validApiCommentParams())
        ->assertCreated();
});

test('store fail', function (): void {
    $this->actingAsUser('sanctum')
        ->json('POST', '/api/v1/posts/31415/comments', validApiCommentParams())
        ->assertNotFound()
        ->assertJson([
            'message' => sprintf('No query results for model [%s] 31415', Post::class)
        ]);
});

test('comment show', function (): void {
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
});

test('comment show fail', function (): void {
    $this->json('GET', '/api/v1/comments/31415')
        ->assertNotFound()
        ->assertJson([
            'message' => sprintf('No query results for model [%s] 31415', Comment::class)
        ]);
});

test('comment delete', function (): void {
    $comment = Comment::factory()->create();

    $this->actingAs($comment->author, 'sanctum')
        ->json('DELETE', "/api/v1/comments/{$comment->id}")
        ->assertNoContent();
});

test('comment delete not found', function (): void {
    $this->actingAsUser('sanctum')
        ->json('DELETE', '/api/v1/comments/31415')
        ->assertNotFound()
        ->assertJson([
            'message' => sprintf('No query results for model [%s] 31415', Comment::class)
        ]);
});

test('comment delete unauthorized', function (): void {
    $comment = Comment::factory()->create();

    $this->actingAsUser('sanctum')
        ->json('DELETE', "/api/v1/comments/{$comment->id}")
        ->assertForbidden()
        ->assertJson([
            'message' => 'This action is unauthorized.'
        ]);
});

test('comments delete unauthenticated', function (): void {
    $comment = Comment::factory()->create();
    $this->json('DELETE', "/api/v1/comments/{$comment->id}")
        ->assertUnauthorized()
        ->assertJson([
            'message' => 'Unauthenticated.'
        ]);
});

/**
 * Valid params for updating or creating a resource
 */
function validApiCommentParams(array $overrides = []): array
{
    return array_merge([
        'content' => 'Star Trek ?',
    ], $overrides);
}
