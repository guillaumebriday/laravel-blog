<?php

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->paragraph,
        'author_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'post_id' => function () {
            return factory(App\Post::class)->create()->id;
        }
    ];
});
