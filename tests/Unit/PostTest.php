<?php

use App\Models\Post;
use Faker\Factory;

test('limit last month posts', function () {
    $limit = 5;
    Post::factory()->count(6)->create();
    $lastPosts = Post::lastMonth($limit)->get();

    expect($lastPosts->count())->toEqual($limit);
});

test('slug', function () {
    $post = Post::factory()->create(['title' => 'The Empire Strikes Back']);
    expect('the-empire-strikes-back')->toEqual($post->slug);
});

test('getting only last month posts', function () {
    $faker = Factory::create();

    // Older Posts
    Post::factory()
        ->count(3)
        ->create()
        ->each(function ($post) use ($faker) {
            $post->posted_at = $faker->dateTimeBetween(carbon('3 months ago'), carbon('2 months ago'));
            $post->save();
        });

    // Newer Posts
    Post::factory()
        ->count(3)
        ->create()
        ->each(function ($post) use ($faker) {
            $post->posted_at = $faker->dateTimeBetween(carbon('3 weeks ago'), carbon('1 weeks ago'));
            $post->save();
        });

    $isDuringLastMonth = true;
    foreach (Post::lastMonth()->get() as $post) {
        $isDuringLastMonth = $post->posted_at->between(carbon('1 month ago'), now());

        if (!$isDuringLastMonth) {
            break;
        }
    }

    expect($isDuringLastMonth)->toBeTrue();
});

test('getting only last week posts', function () {
    $faker = Factory::create();

    // Older Posts
    Post::factory()
        ->count(3)
        ->create()
        ->each(function ($post) use ($faker) {
            $post->posted_at = $faker->dateTimeBetween(carbon('3 months ago'), carbon('2 months ago'));
            $post->save();
        });

    // Newer Posts
    Post::factory()
        ->count(3)
        ->create()
        ->each(function ($post) use ($faker) {
            $post->posted_at = $faker->dateTimeBetween(carbon('1 week ago'), now());
            $post->save();
        });

    $isDuringLastWeek = true;
    foreach (Post::lastWeek()->get() as $post) {
        $isDuringLastWeek = $post->posted_at->between(carbon('1 week ago'), now());

        if (!$isDuringLastWeek) {
            break;
        }
    }

    expect($isDuringLastWeek)->toBeTrue();
});

test('posted at scope applied', function () {
    Post::factory()->create()->update(['posted_at' => carbon('yesterday')]);
    Post::factory()->create()->update(['posted_at' => carbon('tomorrow')]);

    $isBeforeNow = true;
    foreach (Post::all() as $post) {
        $isBeforeNow = $post->posted_at->lt(now());

        if (!$isBeforeNow) {
            break;
        }
    }

    expect($isBeforeNow)->toBeTrue();
    expect(Post::count())->toEqual(1);
});

test('posted at scope not applied', function () {
    $this->actingAsAdmin();

    Post::factory()->create()->update(['posted_at' => carbon('yesterday')]);
    Post::factory()->create()->update(['posted_at' => carbon('tomorrow')]);

    $isBeforeNow = true;
    foreach (Post::all() as $post) {
        $isBeforeNow = $post->posted_at->lt(now());

        if (!$isBeforeNow) {
            break;
        }
    }

    expect($isBeforeNow)->toBeFalse();
    expect(Post::count())->toEqual(2);
});

test('search', function () {
    Post::factory()->create(['title' => 'Hello Luke']);
    Post::factory()->create(['title' => 'Hello Leia']);

    expect(Post::search('Hi Anakin')->get())->toHaveCount(0);
    expect(Post::search('Hello Lu')->get())->toHaveCount(1);
    expect(Post::search('Hello')->get())->toHaveCount(2);
});
