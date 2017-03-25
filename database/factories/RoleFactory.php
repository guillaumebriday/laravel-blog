<?php

use Faker\Generator;
use App\Role;

$factory->define(Role::class, function (Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->state(Role::class, 'admin', function ($faker) {
    return [
        'name' => 'admin'
    ];
});

$factory->state(Role::class, 'editor', function ($faker) {
    return [
        'name' => 'editor'
    ];
});
