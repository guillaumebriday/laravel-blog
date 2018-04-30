<?php

use App\Models\User;
use Faker\Generator;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = 'secret',
        'api_token' => str_random(60),
        'remember_token' => str_random(10),
    ];
});

$factory->state(User::class, 'anakin', function (Generator $faker) {
    return [
        'name' => 'Anakin',
        'email' => 'anakin@skywalker.st'
    ];
});
