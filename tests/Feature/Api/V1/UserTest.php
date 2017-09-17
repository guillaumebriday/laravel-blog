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

        $comments = factory(Comment::class, 2)->create(['author_id' => $user->id]);
        $posts = factory(Post::class, 5)->create(['author_id' => $user->id]);

        $this->json('GET', "/api/v1/users/{$user->id}")
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
                    'posts_count' => 5,
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
