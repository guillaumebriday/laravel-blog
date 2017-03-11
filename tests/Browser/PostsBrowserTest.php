<?php

namespace Tests\Browser;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use App\User;
use Faker\Factory;

class PostsBrowserTest extends BrowserKitTest
{
    use DatabaseMigrations;

    /**
     * it clicks on a post's link in index
     * @return void
     */
    public function testPostIndexShowLink()
    {
        $post = factory(Post::class)->create();

        $this->actingAs($this->user())
            ->visit('/')
            ->click($post->title)
            ->seeRouteIs('posts.show', $post);
    }

    /**
     * it clicks on a post's author link in index
     * @return void
     */
    public function testPostIndexAuthorLink()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        $post = factory(Post::class)->create(['author_id' => $anakin->id]);

        $this->actingAs($this->user())
            ->visit('/')
            ->click('Anakin')
            ->seeRouteIs('users.show', $post->author);
    }

    /**
     * it creates a post through create form
     * @return void
     */
    public function testPostCreateForm()
    {
        $faker = Factory::create();

        $this->actingAs($this->user())
            ->visit('/posts/create')
            ->type($faker->sentence, 'title')
            ->type($faker->paragraph, 'content')
            ->press('Publier')
            ->see('Article créé avec succès');
    }
}
