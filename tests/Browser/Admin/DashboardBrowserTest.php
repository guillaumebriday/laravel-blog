<?php

namespace Tests\Browser\Admin;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;
use Faker\Factory;

class DashboardBrowserTest extends BrowserKitTest
{
    use DatabaseMigrations;

    /**
     * it clicks on posts index link in admin dashboard view
     * @return void
     */
    public function testDashboardPostsIndexLink()
    {
        $this->actingAs($this->admin())
            ->visit('/admin/dashboard')
            ->click('Les articles')
            ->seeRouteIs('admin.posts.index');
    }

    /**
     * it clicks on comments index link in admin dashboard view
     * @return void
     */
    public function testDashboardCommentsIndexLink()
    {
        $this->actingAs($this->admin())
            ->visit('/admin/dashboard')
            ->click('Les commentaires')
            ->seeRouteIs('admin.comments.index');
    }

    /**
     * it clicks on users index link in admin dashboard view
     * @return void
     */
    public function testDashboardUsersIndexLink()
    {
        $this->actingAs($this->admin())
            ->visit('/admin/dashboard')
            ->click('Les utilisateurs')
            ->seeRouteIs('admin.users.index');
    }
}
