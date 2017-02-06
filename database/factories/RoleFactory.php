<?php

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->state(App\Role::class, 'admin', function ($faker) {
    return [
        'name' => 'admin'
    ];
});

$factory->state(App\Role::class, 'editor', function ($faker) {
    return [
        'name' => 'editor'
    ];
});
