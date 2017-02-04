<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;

class DashboardControllerTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testDashboardFail()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->call('GET', route('admin.dashboard'));

        $this->assertRedirectedToRoute('home');
    }
}
