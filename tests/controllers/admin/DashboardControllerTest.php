<?php

namespace Tests\Controllers\Admin;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Role;

class DashboardControllerTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testDashboardFail()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->call('GET', route('admin.dashboard'));

        $this->assertRedirectedToRoute('home');
    }

    public function testDashboard()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());

        $response = $this->actingAs($admin)->call('GET', route('admin.dashboard'));

        $this->assertResponseOk();
        $this->assertViewHas('posts');
        $this->assertViewHas('comments');
        $this->assertViewHas('users');
    }
}
