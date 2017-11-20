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
        $posts = factory(Post::class, 25)->create();
        $users = factory(User::class, 10)->create();
        $comments = factory(Comment::class, 5)->create();

        $response = $this->actingAs($this->admin())
                         ->get('/admin/dashboard');

        $response->assertStatus(200)
                 ->assertSee('Cette semaine')
                 ->assertSee('Voir en détails')
                 ->assertSee('30')
                 ->assertSee('nouveaux articles')
                 ->assertSee('46')
                 ->assertSee('nouveaux utilisateurs')
                 ->assertSee('5')
                 ->assertSee('nouveaux commentaires');
    }
}
