<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Role;

class UserTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testHasRole()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user->roles()->sync([$role->id]);

        $this->assertTrue($user->hasRole($role->name));
    }

    public function testIsAdmin()
    {
        $user = factory(User::class)->create();
        $role_editor = factory(Role::class)->create(['name' => 'editor']);
        $role_admin = factory(Role::class)->create(['name' => 'admin']);

        $user->roles()->sync([$role_editor->id, $role_admin->id]);

        $this->assertTrue($user->isAdmin());
    }

    public function testIsAdminFail()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'editor']);
        $user->roles()->sync([$role->id]);

        $this->assertFalse($user->isAdmin());
    }
}
