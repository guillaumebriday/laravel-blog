<?php

$factory->define(App\NewsletterSubscription::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail
    ];
});
