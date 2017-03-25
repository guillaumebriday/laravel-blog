<?php

use Faker\Generator;
use App\Comment;
use App\User;
use App\Post;

$factory->define(Comment::class, function (Generator $faker) {
    return [
        'content' => $faker->paragraph,
        'author_id' => function () {
            return factory(User::class)->create()->id;
        },
        'post_id' => function () {
            return factory(Post::class)->create()->id;
        }
    ];
});
