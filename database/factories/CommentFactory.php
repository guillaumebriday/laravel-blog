<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Faker\Generator;

$factory->define(Comment::class, function (Generator $faker) {
    return [
        'content' => $faker->paragraph,
        'author_id' => fn () => factory(User::class)->create()->id,
        'post_id' => fn () => factory(Post::class)->create()->id
    ];
});
