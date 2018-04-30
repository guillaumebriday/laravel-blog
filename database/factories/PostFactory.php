<?php

use App\Models\Post;
use App\Models\User;
use Faker\Generator;

$factory->define(Post::class, function (Generator $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'posted_at' => now(),
        'author_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
