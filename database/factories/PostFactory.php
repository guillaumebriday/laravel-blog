<?php

use App\Post;
use App\User;
use Carbon\Carbon;
use Faker\Generator;

$factory->define(Post::class, function (Generator $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'posted_at' => Carbon::now(),
        'author_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
