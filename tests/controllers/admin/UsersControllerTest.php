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
}
