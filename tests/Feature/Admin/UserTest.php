<?php

namespace Tests\Feature\Admin;

use App\Models\Post;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        factory(User::class, 3)->create();
        factory(Post::class, 3)->create(['author_id' => $anakin->id]);

        $this->actingAsAdmin()
            ->get('/admin/users')
            ->assertOk()
            ->assertSee('5 users')
            ->assertSee('3')
            ->assertSee('anakin@skywalker.st')
            ->assertSee('Anakin')
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('Registered at');
    }

    public function testEdit()
    {
        $anakin = factory(User::class)->states('anakin')->create();

        $this->actingAsAdmin()
            ->get("/admin/users/{$anakin->id}/edit")
            ->assertOk()
            ->assertSee('Anakin')
            ->assertSee('Show profile')
            ->assertSee('anakin@skywalker.st')
            ->assertSee('Password confirmation')
            ->assertSee('Roles')
            ->assertSee('Update')
            ->assertSee('Administrator');
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $params = $this->validParams();

        $this->actingAsAdmin()
            ->patch("/admin/users/{$user->id}", $params)
            ->assertRedirect("/admin/users/{$user->id}/edit");

        $this->assertDatabaseHas('users', $params);
        $this->assertEquals($params['email'], $user->refresh()->email);
    }

    public function testUpdateRoles()
    {
        $user = factory(User::class)->create();

        $role_editor = factory(Role::class)->states('editor')->create();
        $params = $this->validParams(['roles' => ['editor' => $role_editor->id]]);

        $this->actingAsAdmin()
            ->patch("/admin/users/{$user->id}", $params)
            ->assertRedirect("/admin/users/{$user->id}/edit");

        $this->assertTrue($user->refresh()->roles->pluck('id')->contains($role_editor->id));
    }

    /**
     * Valid params for updating or creating a resource
     *
     * @param  array  $overrides new params
     * @return array  Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'Anakin',
            'email' => 'anakin@skywalker.st',
        ], $overrides);
    }
}
