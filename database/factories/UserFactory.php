<?php

use Faker\Generator;
use App\User;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
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
