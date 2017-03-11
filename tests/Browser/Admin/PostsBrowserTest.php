<?php

namespace Tests\Browser\Admin;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;
use Faker\Factory;

class PostsBrowserTest extends BrowserKitTest
{
    use DatabaseMigrations;

    /**
     * it clicks on post edit link in admin posts index
     * @return void
     */
    public function testPostIndexEditLink()
    {
        $post = factory(Post::class)->create(['title' => 'The Empire Strikes Back']);

        $this->actingAs($this->admin())
            ->visit('/admin/posts')
            ->click('The Empire Strikes Back')
            ->seeRouteIs('admin.posts.edit', $post);
    }

    /**
     * it clicks on post author profil link in admin posts index
     * @return void
     */
    public function testPostIndexAuthorLink()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        $post = factory(Post::class)->create(['author_id' => $anakin->id]);

        $this->actingAs($this->admin())
            ->visit('/admin/posts')
            ->click('Anakin')
            ->seeRouteIs('users.show', $post->author);
    }

    /**
     * it updates a post through update form
     * @return void
     */
    public function testUpdatePost()
    {
        $author = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $faker = Factory::create();

        $this->actingAs($this->admin())
            ->visit("/admin/posts/{$post->id}/edit")
            ->type($faker->sentence, 'title')
            ->type($faker->paragraph, 'content')
            ->type($faker->datetime->format('d/m/Y H:i:s'), 'posted_at')
            ->select($author->id, 'author_id')
            ->press('Mettre à jour')
            ->see('Article mis à jour avec succès');
    }

    /**
     * it clicks on delete post link
     * @return void
     */
    public function testDeletePost()
    {
        $post = factory(Post::class)->create();

        $this->actingAs($this->admin())
            ->visit("/admin/posts/{$post->id}/edit")
            ->press('Supprimer')
            ->see('Article supprimé avec succès');
    }
}
