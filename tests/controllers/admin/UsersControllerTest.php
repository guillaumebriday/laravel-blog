<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Role;

class AdminUsersControllerTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());

        $response = $this->actingAs($admin)->call('GET', route('admin.users.index'));

        $this->assertResponseOk();
        $this->assertViewHas('users');
    }

    public function testEdit()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());

        $response = $this->actingAs($admin)->call('GET', route('admin.users.edit', $admin));

        $this->assertResponseOk();
        $this->assertViewHas('roles');
        $this->assertViewHas('user');
    }

    public function testUpdate()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $user = factory(User::class)->create();

        $params = [
            'name' => 'luke',
            'email' => 'luke@rebels.y4'
        ];

        $response = $this->actingAs($admin)->call('PATCH', route('admin.users.update', $user->id), $params);

        $user = $user->fresh();
        $this->seeInDatabase('users', $params);
        $this->assertEquals($params['email'], $user->email);
        $this->assertResponseStatus('302');
    }

    public function testUpdateRoles()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $user = factory(User::class)->create();

        $role_editor = factory(Role::class)->states('editor')->create();

        $params = [
            'name' => 'luke',
            'email' => 'luke@rebels.y4',
            'roles' => ['editor' => $role_editor->id]
        ];

        $response = $this->actingAs($admin)->call('PATCH', route('admin.users.update', $user->id), $params);

        $this->assertRedirectedToRoute('admin.users.edit', ['id' => $user->id]);
        $this->assertTrue($user->roles->pluck('id')->contains($role_editor->id));
    }
}
