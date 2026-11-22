<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

test('index', function () {
    $anakin = User::factory()->anakin()->create();

    $post = Post::factory()->create(['author_id' => $anakin->id]);
    Post::factory()->count(2)->create();
    Comment::factory()->count(3)->create(['post_id' => $post->id]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Latest posts')
        ->assertSee($post->title)
        ->assertSee(humanize_date($post->posted_at))
        ->assertSee('3')
        ->assertSee('Anakin');
});

test('search', function () {
    Post::factory()->count(3)->create();
    $post = Post::factory()->create(['title' => 'Hello Obiwan']);

    $this->get('/?q=Hello')
        ->assertOk()
        ->assertSee('1 post found')
        ->assertSee($post->title)
        ->assertSee(humanize_date($post->posted_at));
});

test('show', function () {
    $post = Post::factory()->create();
    Comment::factory()->count(2)->create(['post_id' => $post->id]);
    Comment::factory()->create(['post_id' => $post->id]);

    $this->actingAsUser()
        ->get("/posts/{$post->slug}")
        ->assertOk()
        ->assertSee($post->content)
        ->assertSee($post->title)
        ->assertSee(humanize_date($post->posted_at))
        ->assertSee('3 comments')
        ->assertSee('Comment');
});

test('show unauthenticated', function () {
    $post = Post::factory()->create();

    $this->get("/posts/{$post->slug}")
        ->assertOk()
        ->assertSee('You must be signed in to comment.');
});
