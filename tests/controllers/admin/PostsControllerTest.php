<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;
use App\Role;
use Carbon\Carbon;

class AdminPostsControllerTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());

        $response = $this->actingAs($admin)->call('GET', route('admin.posts.index'));

        $this->assertResponseOk();
        $this->assertViewHas('posts');
    }

    public function testEdit()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $post = factory(Post::class)->create();

        $response = $this->actingAs($admin)->call('GET', route('admin.posts.edit', $post));
        $this->assertResponseOk();
        $this->assertViewHas('post');
        $this->assertViewHas('users');
    }

    public function testUpdate()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $author = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $format = 'd/m/Y H:i:s';

        $params = [
            'title' => 'hello world',
            'content' => "I'm a content",
            'posted_at' => Carbon::yesterday()->format($format),
            'author_id' => $author->id,
        ];

        $response = $this->actingAs($admin)->call('PUT', route('admin.posts.update', $post), $params);

        $post = $post->fresh();
        $params['posted_at'] = Carbon::createFromFormat($format, $params['posted_at']);

        $this->seeInDatabase('posts', $params);
        $this->assertEquals($params['content'], $post->content);
        $this->assertResponseStatus('302');
    }
}
