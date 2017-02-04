<?php

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
        $user = factory(User::class)->create();
        $role_admin = factory(Role::class)->create(['name' => 'admin']);
        $user->roles()->sync([$role_admin->id]);

        $response = $this->actingAs($user)->call('GET', route('admin.dashboard'));

        $this->assertResponseOk();
        $this->assertViewHas('posts');
        $this->assertViewHas('comments');
        $this->assertViewHas('users');
    }
}
