<?php

use Faker\Generator;
use App\Post;
use App\User;
use App\Like;

$factory->define(Like::class, function (Generator $faker) {
    return [
      'likeable_type' => 'App\Post',
      'likeable_id' => function () {
          return factory(Post::class)->create()->id;
      },
      'author_id' => function () {
          return factory(User::class)->create()->id;
      }
    ];
});
