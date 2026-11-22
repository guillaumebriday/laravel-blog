<?php

use App\Models\Post;

test('post like', function () {
    $post = Post::factory()->create();

    $this->actingAsUser('sanctum')
        ->json('POST', "/api/v1/posts/{$post->id}/likes")
        ->assertCreated();

    expect($post->likes)->toHaveCount(1);
});

test('post dislike', function () {
    $user = $this->user();
    $post = Post::factory()->create();
    $post->likes()->create(['author_id' => $user->id]);

    $this->actingAs($user, 'sanctum')
        ->json('DELETE', "/api/v1/posts/{$post->id}/likes")
        ->assertOk();

    expect($post->likes)->toHaveCount(0);
});
