<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

test('post index', function () {
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

test('users posts', function () {
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

test('users posts fail', function () {
    $user = User::factory()->create();
    Post::factory()->create(['author_id' => $user->id]);

    $this->json('GET', '/api/v1/users/314/posts')
        ->assertNotFound()
        ->assertJson([
            'message' => sprintf('No query results for model [%s] 314', User::class)
        ]);
});

test('post show', function () {
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

test('post show fail', function () {
    $this->json('GET', '/api/v1/posts/31415')
        ->assertNotFound()
        ->assertJson([
            'message' => sprintf('No query results for model [%s] 31415', Post::class)
        ]);
});

test('update', function () {
    $post = Post::factory()->create();
    $params = validApiPostParams();

    $this->actingAsAdmin('sanctum')
        ->json('PATCH', "/api/v1/posts/{$post->id}", $params)
        ->assertOk();

    $post->refresh();

    $this->assertDatabaseHas('posts', ['posted_at' => Carbon::parse($params['posted_at'])->toDateTimeString()] + $params);
    expect($post->title)->toEqual($params['title']);
    expect($post->content)->toEqual($params['content']);
});

test('update fail', function () {
    $post = Post::factory()->create();

    $this->actingAsUser('sanctum')
        ->json('PATCH', "/api/v1/posts/{$post->id}", validApiPostParams())
        ->assertForbidden()
        ->assertJson([
            'message' => 'This action is unauthorized.'
        ]);
});

test('store post', function () {
    $params = validApiPostParams();

    $this->actingAsAdmin('sanctum')
        ->json('POST', '/api/v1/posts/', $params)
        ->assertCreated();

    $params['posted_at'] = Carbon::yesterday()->second(0)->toDateTimeString();
    $this->assertDatabaseHas('posts', ['posted_at' => Carbon::parse($params['posted_at'])->toDateTimeString()] + $params);
});

test('store post unauthorized', function () {
    $this->actingAsUser('sanctum')
        ->json('POST', '/api/v1/posts/', validApiPostParams())
        ->assertForbidden()
        ->assertJson([
            'message' => 'This action is unauthorized.'
        ]);
});

test('post delete', function () {
    $post = Post::factory()->create();

    $this->actingAsAdmin('sanctum')
        ->json('DELETE', "/api/v1/posts/{$post->id}")
        ->assertNoContent();

    $this->assertDatabaseMissing('posts', $post->toArray());
});

test('post delete unauthorized', function () {
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
        'posted_at' => Carbon::yesterday()->format('Y-m-d\TH:i'),
        'author_id' => test()->admin()->id,
    ], $overrides);
}
