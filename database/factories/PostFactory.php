<?php

use Faker\Generator;
use App\Post;
use App\User;

$factory->define(Post::class, function (Generator $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'author_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
