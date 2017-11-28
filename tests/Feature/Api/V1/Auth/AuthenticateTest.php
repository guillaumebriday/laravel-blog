<?php

namespace Tests\Feature\Api\V1\Auth;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticate()
    {
        $user = factory(User::class)->states('anakin')->create(['password' => '4nak1n']);
        $role = factory(Role::class)->states('editor')->create();
        $user->roles()->save($role);

        $res = $this->json('POST', '/api/v1/authenticate', [
                'email' => 'anakin@skywalker.st',
                'password' => '4nak1n'
            ])
            ->assertStatus(200)
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
    }

    public function testAuthenticateFail()
    {
        $user = factory(User::class)->states('anakin')->create(['password' => '4nak1n']);
        $user->roles()->save(
            factory(Role::class)->states('editor')->create()
        );

        $this->json('POST', '/api/v1/authenticate', [
                'email' => 'anakin@skywalker.st',
                'password' => 'Luk3'
            ])
            ->assertStatus(401)
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }
}
