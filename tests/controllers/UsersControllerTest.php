<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UsersControllerTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testShow()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->call('GET', route('users.show', $user->id));

        $this->assertResponseOk();
        $this->assertViewHas('user');
        $this->assertViewHas('posts');
        $this->assertViewHas('comments');
        $this->assertViewHas('roles');
    }

    public function testEdit()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->call('GET', route('users.edit', $user->id));

        $this->assertResponseOk();
        $this->assertViewHas('user');
    }

    public function testEditFail()
    {
        $user = factory(User::class)->create();
        $anakin = factory(User::class)->create(['name' => 'anakin']);

        $response = $this->actingAs($user)->call('GET', route('users.edit', $anakin->id));

        $this->assertResponseStatus('403');
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $params = [
            'name' => 'Palpatine',
            'email' => 'darthsidious@deathstar.ds'
        ];

        $response = $this->actingAs($user)->call('PATCH', route('users.update', $user->id), $params);

        $user = $user->fresh();
        $this->seeInDatabase('users', $params);
        $this->assertEquals($params['email'], $user->email);
        $this->assertResponseStatus('302');
    }

    public function testUpdatePassword()
    {
        $user = factory(User::class)->create();
        $params = [
            'name' => 'Palpatine',
            'email' => 'darthsidious@deathstar.ds',
            'password' => '7h3_3mp1r3_57r1k35_b4ck',
            'password_confirmation' => '7h3_3mp1r3_57r1k35_b4ck'
        ];

        $response = $this->actingAs($user)->call('PATCH', route('users.update', $user->id), $params);

        $user = $user->fresh();
        $this->assertTrue(Hash::check($params['password'], $user->password));
        $this->assertRedirectedToRoute('users.show', ['id' => $user->id]);
    }

    public function testUpdateRoles()
    {
        $user = factory(User::class)->create();
        $role_admin = factory(Role::class)->states('admin')->create();
        $role_editor = factory(Role::class)->create(['name' => 'editor']);
        $user->roles()->sync([$role_admin->id]);

        $params = [
            'name' => 'Palpatine',
            'email' => 'darthsidious@deathstar.ds',
            'roles' => ['editor' => $role_editor->id]
        ];

        $response = $this->actingAs($user)->call('PATCH', route('users.update', $user->id), $params);

        $this->assertRedirectedToRoute('users.show', ['id' => $user->id]);
        $this->assertTrue($user->roles->pluck('id')->contains($role_editor->id));
    }

    public function testUpdateFail()
    {
        $user = factory(User::class)->create();
        $anakin = factory(User::class)->create(['name' => 'anakin']);
        $params = [
            'name' => 'Palpatine',
            'email' => 'darthsidious@deathstar.ds'
        ];

        $response = $this->actingAs($user)->call('PATCH', route('users.update', $anakin->id), $params);

        $this->notSeeInDatabase('users', $params);
        $this->assertResponseStatus('403');
    }

    public function testDoesNotUpdateRoles()
    {
        $user = factory(User::class)->create();
        $role_admin = factory(Role::class)->states('admin')->create();

        $params = [
            'name' => 'Palpatine',
            'email' => 'darthsidious@deathstar.ds',
            'roles' => ['admin' => $role_admin->id]
        ];

        $response = $this->actingAs($user)->call('PATCH', route('users.update', $user->id), $params);

        $this->assertRedirectedToRoute('users.show', ['id' => $user->id]);
        $this->assertFalse($user->roles->pluck('id')->contains($role_admin->id));
    }
}
