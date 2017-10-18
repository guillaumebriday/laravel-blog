<?php

namespace Tests\Browser;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Media;
use App\User;
use Faker\Factory;

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
