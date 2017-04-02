<?php

namespace Tests\Browser;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Media;
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
     * it clicks on a post's edit link in post view
     * @return void
     */
    public function testPostEditLink()
    {
        $post = factory(Post::class)->create();

        $this->actingAs($post->author)
            ->visit("posts/{$post->id}")
            ->click('Éditer')
            ->seeRouteIs('posts.edit', $post);
    }

    /**
     * it clicks on the unset thumbnail link in post edit view
     * @return void
     */
    public function testPostUnsetThumbnailLink()
    {
        $post = factory(Post::class)->create();
        $post->storeAndSetThumbnail(UploadedFile::fake()->image('file.png'));

        $this->actingAs($post->author)
            ->visit("posts/{$post->id}/edit")
            ->press("Supprimer l'image à la une")
            ->seeRouteIs('posts.edit', $post)
            ->see('Article mis à jour avec succès');

        Storage::delete($post->thumbnail()->filename);
    }

    /**
     * it updates a post through update form
     * @return void
     */
    public function testPostUpdateForm()
    {
        $faker = Factory::create();
        $post = factory(Post::class)->create();

        $this->actingAs($post->author)
            ->visit("posts/{$post->id}/edit")
            ->type($faker->sentence, 'title')
            ->type($faker->paragraph, 'content')
            ->press('Publier')
            ->see('Article mis à jour avec succès');
    }

    /**
     * it creates a post through create form
     * @return void
     */
    public function testPostCreateForm()
    {
        $faker = Factory::create();
        $file = UploadedFile::fake()->image('file.png');

        $this->actingAs($this->user())
            ->visit('/posts/create')
            ->type($faker->sentence, 'title')
            ->type($faker->paragraph, 'content')
            ->attach($file->getPathname(), 'thumbnail')
            ->press('Publier')
            ->see('Article créé avec succès');

        Storage::delete(Post::first()->thumbnail()->filename);
    }
}
