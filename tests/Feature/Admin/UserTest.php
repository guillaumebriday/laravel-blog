<?php

use App\Models\Post;
use App\Models\Role;
use App\Models\User;

test('index', function () {
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
});

test('edit', function () {
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
});

test('update', function () {
    $user = User::factory()->create();
    $params = validAdminUserParams();

    $this->actingAsAdmin()
        ->patch("/admin/users/{$user->id}", $params)
        ->assertRedirect("/admin/users/{$user->id}/edit");

    $this->assertDatabaseHas('users', $params);
    expect($user->refresh()->email)->toEqual($params['email']);
});

test('update roles', function () {
    $user = User::factory()->create();

    $role_editor = Role::factory()->editor()->create();
    $params = validAdminUserParams(['roles' => ['editor' => $role_editor->id]]);

    $this->actingAsAdmin()
        ->patch("/admin/users/{$user->id}", $params)
        ->assertRedirect("/admin/users/{$user->id}/edit");

    expect($user->refresh()->roles->pluck('id')->contains($role_editor->id))->toBeTrue();
});

/**
 * Valid params for updating or creating a resource
 */
function validAdminUserParams(array $overrides = []): array
{
    return array_merge([
        'name' => 'Anakin',
        'email' => 'anakin@skywalker.st',
    ], $overrides);
}
