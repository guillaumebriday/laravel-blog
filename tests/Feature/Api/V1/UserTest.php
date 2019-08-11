<?php

namespace Tests\Feature\Api\V1;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserIndex()
    {
        factory(User::class, 2)
            ->create()
            ->each(fn ($user) => $user->roles()->save(factory(Role::class)->create()));

        $this->json('GET', '/api/v1/users')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [[
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
                ]],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ]
            ]);
    }

    public function testUserShow()
    {
        $user = factory(User::class)->states('anakin')->create();
        $role = factory(Role::class)->states('editor')->create();
        $user->roles()->save($role);

        factory(Comment::class, 2)->create(['author_id' => $user->id]);
        factory(Post::class, 2)->create(['author_id' => $user->id]);

        $this->json('GET', "/api/v1/users/{$user->id}")
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
                ]
            ])
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => 'Anakin',
                    'email' => 'anakin@skywalker.st',
                    'provider' => null,
                    'provider_id' => null,
                    'registered_at' => $user->registered_at->toIso8601String(),
                    'comments_count' => 2,
                    'posts_count' => 2,
                    'roles' => [[
                        'id' => $role->id,
                        'name' => 'editor'
                    ]]
                ],
            ]);
    }

    public function testUpdate()
    {
        $user = $this->user();
        $params = $this->validParams();

        $this->actingAs($user, 'api')
            ->json('PATCH', "/api/v1/users/{$user->id}", $params)
            ->assertOk();

        $user->refresh();

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
