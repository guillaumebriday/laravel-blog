<?php

namespace Tests\Browser;

use App\Post;

use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest;

class PostsBrowserTest extends BrowserKitTest
{
    use RefreshDatabase;

    public function testPostIndexShowLink()
    {
        $post = factory(Post::class)->create();

        $this->visit('/')
            ->click($post->title)
            ->seeRouteIs('posts.show', $post);
    }

    public function testPostIndexAuthorLink()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        $post = factory(Post::class)->create(['author_id' => $anakin->id]);

        $this->visit('/')
            ->click('Anakin')
            ->seeRouteIs('users.show', $post->author);
    }
}
