<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Date;

test('post index', function (): void {
    Post::factory()->count(2)->create();

    $this->json('GET', '/api/v1/posts')
        ->assertOk()
        ->assertJsonStructure([
            'data' => [[
                'id',
                'title',
                'slug',
                'content',
                'posted_at',
                'author_id',
                'comments_count'
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

test('users posts', function (): void {
    $user = User::factory()->create();
    Post::factory()->create(['author_id' => $user->id]);

    $this->json('GET', "/api/v1/users/{$user->id}/posts")
        ->assertOk()
        ->assertJsonStructure([
            'data' => [[
                'id',
                'title',
                'slug',
                'content',
                'posted_at',
                'author_id',
                'comments_count'
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

test('users posts fail', function (): void {
    $user = User::factory()->create();
    Post::factory()->create(['author_id' => $user->id]);

    $this->json('GET', '/api/v1/users/314/posts')
        ->assertNotFound()
        ->assertJson([
            'message' => sprintf('No query results for model [%s] 314', User::class)
        ]);
});

test('post show', function (): void {
    $post = Post::factory()->create([
        'title' => 'The Empire Strikes Back',
        'content' => 'A Star Wars Story'
    ]);
    Comment::factory()->count(2)->create(['post_id' => $post->id]);

    $this->json('GET', "/api/v1/posts/{$post->id}")
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'slug',
                'content',
                'posted_at',
                'author_id',
                'comments_count'
            ],
        ])
        ->assertJson([
            'data' => [
                'id' => $post->id,
                'title' => 'The Empire Strikes Back',
                'slug' => 'the-empire-strikes-back',
                'content' => 'A Star Wars Story',
                'posted_at' => $post->posted_at->toIso8601String(),
                'author_id' => $post->author_id,
                'comments_count' => 2
            ],
        ]);
});

test('post show fail', function (): void {
    $this->json('GET', '/api/v1/posts/31415')
        ->assertNotFound()
        ->assertJson([
            'message' => sprintf('No query results for model [%s] 31415', Post::class)
        ]);
});

test('update', function (): void {
    $post = Post::factory()->create();
    $params = validApiPostParams();

    $this->actingAsAdmin('sanctum')
        ->json('PATCH', "/api/v1/posts/{$post->id}", $params)
        ->assertOk();

    $post->refresh();

    $this->assertDatabaseHas('posts', ['posted_at' => Date::parse($params['posted_at'])->toDateTimeString()] + $params);
    expect($post->title)->toEqual($params['title']);
    expect($post->content)->toEqual($params['content']);
});

test('update fail', function (): void {
    $post = Post::factory()->create();

    $this->actingAsUser('sanctum')
        ->json('PATCH', "/api/v1/posts/{$post->id}", validApiPostParams())
        ->assertForbidden()
        ->assertJson([
            'message' => 'This action is unauthorized.'
        ]);
});

test('store post', function (): void {
    $params = validApiPostParams();

    $this->actingAsAdmin('sanctum')
        ->json('POST', '/api/v1/posts/', $params)
        ->assertCreated();

    $params['posted_at'] = Date::yesterday()->second(0)->toDateTimeString();
    $this->assertDatabaseHas('posts', ['posted_at' => Date::parse($params['posted_at'])->toDateTimeString()] + $params);
});

test('store post unauthorized', function (): void {
    $this->actingAsUser('sanctum')
        ->json('POST', '/api/v1/posts/', validApiPostParams())
        ->assertForbidden()
        ->assertJson([
            'message' => 'This action is unauthorized.'
        ]);
});

test('post delete', function (): void {
    $post = Post::factory()->create();

    $this->actingAsAdmin('sanctum')
        ->json('DELETE', "/api/v1/posts/{$post->id}")
        ->assertNoContent();

    $this->assertDatabaseMissing('posts', $post->toArray());
});

test('post delete unauthorized', function (): void {
    $post = Post::factory()->create();

    $this->actingAsUser('sanctum')
        ->json('DELETE', "/api/v1/posts/{$post->id}")
        ->assertForbidden()
        ->assertJson([
            'message' => 'This action is unauthorized.'
        ]);

    $this->assertDatabaseHas('posts', $post->toArray());
});

/**
 * Valid params for updating or creating a resource
 */
function validApiPostParams(array $overrides = []): array
{
    return array_merge([
        'title' => 'Star Trek ?',
        'content' => 'Star Wars.',
        'posted_at' => Date::yesterday()->format('Y-m-d\TH:i'),
        'author_id' => test()->admin()->id,
    ], $overrides);
}
