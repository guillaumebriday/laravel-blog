<?php

namespace Tests\Feature\Admin;

use App\Comment;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function testDashboard()
    {
        factory(Post::class, 2)->create();
        factory(User::class, 2)->create();
        factory(Comment::class, 2)->create();

        $this->actingAsAdmin()
            ->get('/admin/dashboard')
            ->assertStatus(200)
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
