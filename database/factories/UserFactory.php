<?php

use App\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(User::class, 'anakin', function (Faker\Generator $faker) {
    return [
        'name' => 'Anakin',
        'email' => 'anakin@skywalker.st'
    ];
});
