<?php

use App\Models\Like;
use App\Models\Post;

test('likes', function () {
    $post = Post::factory()->create();
    Like::factory()->create(['likeable_id' => $post->id]);

    expect($post->likes)->toHaveCount(1);
});

test('like', function () {
    $this->actingAsUser();
    $post = Post::factory()->create();

    $post->like();

    expect($post->likes)->toHaveCount(1);
});

test('dislike', function () {
    $this->actingAsUser();
    $post = Post::factory()->create();

    $post->like();
    $post->dislike();

    expect($post->likes)->toHaveCount(0);
});

test('is liked', function () {
    $this->actingAsUser();
    $post = Post::factory()->create();

    $post->like();

    expect($post->isLiked())->toBeTrue();
});

test('is not liked', function () {
    $this->actingAsUser();
    $post = Post::factory()->create();

    expect($post->isLiked())->toBeFalse();
});
