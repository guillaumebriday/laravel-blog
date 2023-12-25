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
        $anakin = User::factory()->anakin()->create();
        User::factory()->count(3)->create();
        Post::factory()->count(3)->create(['author_id' => $anakin->id]);

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
        $anakin = User::factory()->anakin()->create();

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
        $user = User::factory()->create();
        $params = $this->validParams();

        $this->actingAsAdmin()
            ->patch("/admin/users/{$user->id}", $params)
            ->assertRedirect("/admin/users/{$user->id}/edit");

        $this->assertDatabaseHas('users', $params);
        $this->assertEquals($params['email'], $user->refresh()->email);
    }

    public function testUpdateRoles()
    {
        $user = User::factory()->create();

        $role_editor = Role::factory()->editor()->create();
        $params = $this->validParams(['roles' => ['editor' => $role_editor->id]]);

        $this->actingAsAdmin()
            ->patch("/admin/users/{$user->id}", $params)
            ->assertRedirect("/admin/users/{$user->id}/edit");

        $this->assertTrue($user->refresh()->roles->pluck('id')->contains($role_editor->id));
    }

    /**
     * Valid params for updating or creating a resource
     */
    private function validParams(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Anakin',
            'email' => 'anakin@skywalker.st',
        ], $overrides);
    }
}
