<?php

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Faker\Generator;

$factory->define(Like::class, function (Generator $faker) {
    return [
      'likeable_type' => 'App\Models\Post',
      'likeable_id' => function () {
          return factory(Post::class)->create()->id;
      },
      'author_id' => function () {
          return factory(User::class)->create()->id;
      }
    ];
});
