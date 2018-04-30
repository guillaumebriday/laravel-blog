<?php

use App\Models\NewsletterSubscription;
use Faker\Generator;

$factory->define(NewsletterSubscription::class, function (Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail
    ];
});
