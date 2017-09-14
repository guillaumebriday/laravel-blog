<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;
use App\Comment;
use App\Role;
use Carbon\Carbon;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserIndex()
    {
        $users = factory(User::class, 10)
                    ->create()
                    ->each(function ($user) {
                        $user->roles()->save(factory(Role::class)->create());
                    });

        $this->json('GET', '/api/v1/users')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'type',
                    'id',
                    'attributes' => [
                        'name',
                        'email',
                        'provider',
                        'provider_id',
                        'registered_at',
                        'comments_count',
                        'posts_count'
                    ],
                    'relationships' => [
                        'roles' => [
                            'data'
                        ]
                    ]
                ]],
                'included' => [[
                    'type',
                    'id',
                    'attributes' => [
                        'name'
                    ]
                ]],
                'meta' => [
                    'pagination' => [
                        'total'
                    ]
                ],
                'links' => [
                    'self',
                    'first',
                    'last'
                ]
            ]);
    }

    public function testUserShow()
    {
        $user = factory(User::class)->states('anakin')->create();
        $role = factory(Role::class)->states('editor')->create();
        $user->roles()->save($role);

        $comments = factory(Comment::class, 2)->create(['author_id' => $user->id]);
        $posts = factory(Post::class, 5)->create(['author_id' => $user->id]);

        $this->json('GET', "/api/v1/users/{$user->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'name',
                        'email',
                        'provider',
                        'provider_id',
                        'registered_at',
                        'comments_count',
                        'posts_count'
                    ],
                    'relationships' => [
                        'roles' => [
                            'data'
                        ]
                    ]
                ],
                'included' => [[
                    'type',
                    'id',
                    'attributes' => [
                        'name'
                    ]
                ]],
            ])
            ->assertJson([
                'data' => [
                    'type' => 'users',
                    'id' => $user->id,
                    'attributes' => [
                        'name' => 'Anakin',
                        'email' => 'anakin@skywalker.st',
                        'provider' => null,
                        'provider_id' => null,
                        'registered_at' => $user->registered_at->toIso8601String(),
                        'comments_count' => 2,
                        'posts_count' => 5
                    ],
                    'relationships' => [
                        'roles' => [
                            'data' => [[
                                'type' => 'roles',
                                'id' => $role->id
                            ]]
                        ]
                    ]
                ],
                'included' => [[
                    'type' => 'roles',
                    'id' => (int) $role->id,
                    'attributes' => [
                        'name' => $role->name
                    ]
                ]],
            ]);
    }

    public function testUpdate()
    {
        $user = $this->user();
        $params = $this->validParams();

        $response = $this->actingAs($user, 'api')->json('PATCH', "/api/v1/users/{$user->id}", $params);

        $user->refresh();

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $params);
        $this->assertEquals($params['email'], $user->email);
        $this->assertEquals($params['name'], $user->name);
    }

    /**
     * Valid params for updating or creating a resource
     *
     * @param  array $overrides new params
     * @return array Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'Anakin',
            'email' => 'anakin@skywalker.st',
        ], $overrides);
    }
}
