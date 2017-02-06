<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;

class PostsControllerTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->call('GET', route('home'));

        $this->assertResponseOk();
    }

    public function testIndexHasPosts()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->call('GET', route('home'));

        $this->assertViewHas('posts');
    }

    public function testShow()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->actingAs($user)->call('GET', route('posts.show', $post->id));

        $this->assertResponseOk();
    }

    public function testShowHasPost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->actingAs($user)->call('GET', route('posts.show', $post->id));

        $this->assertViewHas('post');
    }

    public function testStore()
    {
        $user = factory(User::class)->create();
        $params = [
            'title' => 'post',
            'content' => 'hello world'
        ];

        $response = $this->actingAs($user)->call('POST', route('posts.store'), $params);

        $this->seeInDatabase('posts', $params);
        $this->assertResponseStatus('302');
    }

    public function testStoreFail()
    {
        $user = factory(User::class)->create();
        $params = [ 'title' => 'post' ];

        $response = $this->actingAs($user)->call('POST', route('posts.store'), $params);

        $this->assertSessionHasErrors(['content']);
        $this->assertResponseStatus('302');
    }
}
