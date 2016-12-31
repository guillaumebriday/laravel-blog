<?php

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'author_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
