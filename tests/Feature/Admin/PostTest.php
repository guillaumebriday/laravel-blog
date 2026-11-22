<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Date;

test('index', function (): void {
    $anakin = User::factory()->anakin()->create();
    Post::factory()->create(['author_id' => $anakin->id]);
    Post::factory()->count(3)->create();

    $this->actingAsAdmin()
        ->get('/admin/posts')
        ->assertOk()
        ->assertSee('4 posts')
        ->assertSee('Anakin')
        ->assertSee('Author')
        ->assertSee('Posted at')
        ->assertSee('Title');
});

test('create', function (): void {
    $this->actingAsAdmin()
        ->get('/admin/posts/create')
        ->assertOk()
        ->assertSee('Create post')
        ->assertSee('Title')
        ->assertSee('Author')
        ->assertSee('Posted at')
        ->assertSee('Content')
        ->assertSee('Save');
});

test('store', function (): void {
    $params = validAdminPostParams();

    $this->actingAsAdmin()
        ->post('/admin/posts', $params)
        ->assertStatus(302);

    $params['posted_at'] = now()->second(0)->toDateTimeString();

    $post = Post::first();

    $this->assertDatabaseHas('posts', ['posted_at' => Date::parse($params['posted_at'])->toDateTimeString()] + $params);
});

test('store fail', function (): void {
    $params = validAdminPostParams(['content' => null]);

    $this->actingAsAdmin()
        ->post('/admin/posts', $params)
        ->assertStatus(302)
        ->assertSessionHas('errors');
});

test('edit', function (): void {
    $anakin = $this->admin(['name' => 'Anakin', 'email' => 'anakin@skywalker.st']);
    $post = Post::factory()->create(['author_id' => $anakin->id]);

    $this->actingAs($anakin)
        ->get("/admin/posts/{$post->slug}/edit")
        ->assertOk()
        ->assertSee('Anakin')
        ->assertSee('Show post')
        ->assertSee($post->title)
        ->assertSee($post->content)
        ->assertSee(humanize_date($post->posted_at, 'Y-m-d\TH:i'))
        ->assertSee('Update')
        ->assertSee('Posted at');
});

test('update', function (): void {
    $post = Post::factory()->create();
    $params = validAdminPostParams();

    $response = $this->actingAsAdmin()->patch("/admin/posts/{$post->slug}", $params);

    $post->refresh();

    $response->assertRedirect("/admin/posts/{$post->slug}/edit");

    $this->assertDatabaseHas('posts', ['posted_at' => Date::parse($params['posted_at'])->toDateTimeString()] + $params);
    expect($post->content)->toEqual($params['content']);
});

test('delete', function (): void {
    $post = Post::factory()->create();
    Comment::factory()
        ->count(2)
        ->create()
        ->each(function ($comment) use ($post): void {
            $comment->post_id = $post->id;
            $comment->save();
        });

    $this->actingAsAdmin()
        ->delete("/admin/posts/{$post->slug}")
        ->assertStatus(302);

    $this->assertDatabaseMissing('posts', $post->toArray());
    expect(Comment::all()->isEmpty())->toBeTrue();
});

/**
 * Valid params for updating or creating a resource
 *
 * @param  array  $overrides  new params
 */
function validAdminPostParams(array $overrides = []): array
{
    return array_merge([
        'title' => 'hello world',
        'content' => "I'm a content",
        'posted_at' => now()->format('Y-m-d\TH:i'),
        'author_id' => test()->admin()->id,
    ], $overrides);
}
