<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('authenticate', function (): void {
    $user = User::factory()->anakin()->create(['password' => Hash::make('demodemo')]);
    $role = Role::factory()->editor()->create();
    $user->roles()->save($role);

    $res = $this->json('POST', '/api/v1/authenticate', [
        'email' => 'anakin@skywalker.st',
        'password' => 'demodemo'
    ])
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'provider',
                'provider_id',
                'registered_at',
                'comments_count',
                'posts_count',
                'roles' => [[
                    'id',
                    'name'
                ]]
            ],
            'meta' => [
                'access_token'
            ]
        ]);
});

test('authenticate fail', function (): void {
    $user = User::factory()->anakin()->create(['password' => Hash::make('demodemo')]);
    $user->roles()->save(
        Role::factory()->editor()->create()
    );

    $this->json('POST', '/api/v1/authenticate', [
        'email' => 'anakin@skywalker.st',
        'password' => 'Luk3'
    ])
        ->assertUnauthorized()
        ->assertJson([
            'message' => 'This action is unauthorized.'
        ]);
});
