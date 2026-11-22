<?php

use App\Models\Role;
use App\Models\User;
use Faker\Factory;

test('user has role', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();
    $user->roles()->attach($role);

    expect($user->hasRole($role->name))->toBeTrue();
});

test('user is admin', function () {
    $admin = User::factory()->create();
    $role_editor = Role::factory()->editor()->create();
    $role_admin = Role::factory()->admin()->create();

    $admin->roles()->sync([$role_admin->id, $role_editor->id]);

    expect($admin->isAdmin())->toBeTrue();
});

test('user is not admin', function () {
    $user = User::factory()->create();
    $user->roles()->attach(
        Role::factory()->editor()->create()
    );

    expect($user->isAdmin())->toBeFalse();
});

test('getting only last week users', function () {
    $faker = Factory::create();

    // Older Users
    User::factory()
        ->count(10)
        ->create()
        ->each(function ($user) use ($faker) {
            $user->registered_at = $faker->dateTimeBetween(carbon('3 months ago'), carbon('2 months ago'));
            $user->save();
        });

    // Newer Users
    User::factory()
        ->count(3)
        ->create()
        ->each(function ($user) use ($faker) {
            $user->registered_at = $faker->dateTimeBetween(carbon('1 week ago'), now());
            $user->save();
        });

    $isDuringLastWeek = true;
    foreach (User::lastWeek()->get() as $user) {
        $isDuringLastWeek = $user->registered_at->between(carbon('1 week ago'), now());

        if (!$isDuringLastWeek) {
            break;
        }
    }

    expect($isDuringLastWeek)->toBeTrue();
});

test('fullname attribute', function () {
    $user = User::factory()->create(['name' => 'LEIA']);

    expect($user->fullname)->toEqual('Leia');
});

test('registered at', function () {
    $user = User::factory()->create();
    expect(now()->timestamp)->toEqualWithDelta($user->registered_at->timestamp, 1);
});

test('authors scope', function () {
    $editor = Role::factory()->editor()->create();
    User::factory()->count(10)->create();
    User::factory()
        ->count(3)
        ->create()
        ->each(function ($user) use ($editor) {
            $user->roles()->attach($editor);
        });

    $authors = User::authors()->get();

    $hasOnlyAuthors = true;
    foreach ($authors as $author) {
        if (!$author->canBeAuthor()) {
            $hasOnlyAuthors = false;
            break;
        }
    }

    expect($hasOnlyAuthors)->toBeTrue();
    expect($authors)->toHaveCount(3);
});
