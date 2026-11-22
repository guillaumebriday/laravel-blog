<?php

use App\Models\Comment;
use Faker\Factory;

test('posted at', function (): void {
    $comment = Comment::factory()->create();
    expect(now()->timestamp)->toEqualWithDelta($comment->posted_at->timestamp, 1);
});

test('getting only last week comments', function (): void {
    $faker = Factory::create();

    // Older Comments
    Comment::factory()
        ->count(3)
        ->create()
        ->each(function ($comment) use ($faker): void {
            $comment->posted_at = $faker->dateTimeBetween(carbon('3 months ago'), carbon('2 months ago'));
            $comment->save();
        });

    // Newer Comments
    Comment::factory()
        ->count(3)
        ->create()
        ->each(function ($comment) use ($faker): void {
            $comment->posted_at = $faker->dateTimeBetween(carbon('1 week ago'), now());
            $comment->save();
        });

    $isDuringLastWeek = true;
    foreach (Comment::lastWeek()->get() as $comment) {
        $isDuringLastWeek = $comment->posted_at->between(carbon('1 week ago'), now());

        if (!$isDuringLastWeek) {
            break;
        }
    }

    expect($isDuringLastWeek)->toBeTrue();
});
