<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Role;
use App\Comment;

class AdminCommentsControllerTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $comments = factory(Comment::class, 10)->create();

        $response = $this->actingAs($admin)->call('GET', route('admin.comments.index'));

        $this->assertResponseOk();
        $this->assertViewHas('comments');
    }
}
