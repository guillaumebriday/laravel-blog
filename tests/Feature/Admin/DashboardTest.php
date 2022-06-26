<?php

namespace Tests\Feature\Admin;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function testDashboard()
    {
        Post::factory()->count(2)->create();
        User::factory()->count(2)->create();
        Comment::factory()->count(2)->create();

        $this->actingAsAdmin()
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('This week')
            ->assertSee('Details')
            ->assertSee('4')
            ->assertSee('new posts')
            ->assertSee('9')
            ->assertSee('new users')
            ->assertSee('2')
            ->assertSee('new comments');
    }
}
