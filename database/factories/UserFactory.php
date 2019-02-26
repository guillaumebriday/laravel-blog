<?php

use App\Models\User;
use Faker\Generator;
use Illuminate\Support\Str;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = 'password',
        'api_token' => Str::random(60),
        'remember_token' => Str::random(10),
        'email_verified_at' => now(),
    ];
});

$factory->state(User::class, 'anakin', function (Generator $faker) {
    return [
        'name' => 'Anakin',
        'email' => 'anakin@skywalker.st'
    ];
});
