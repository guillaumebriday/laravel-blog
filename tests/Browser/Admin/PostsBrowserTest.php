<?php

namespace Tests\Browser\Admin;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Post;
use Faker\Factory;
use Carbon\Carbon;

class PostsBrowserTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testPostIndexEditLink()
    {
        $post = factory(Post::class)->create(['title' => 'The Empire Strikes Back']);

        $this->actingAs($this->admin())
            ->visit('/admin/posts')
            ->click('The Empire Strikes Back')
            ->seeRouteIs('admin.posts.edit', $post);
    }

    public function testPostIndexAuthorLink()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        $post = factory(Post::class)->create(['author_id' => $anakin->id]);

        $this->actingAs($this->admin())
            ->visit('/admin/posts')
            ->click('Anakin')
            ->seeRouteIs('users.show', $post->author);
    }

    public function testUpdatePost()
    {
        $author = $this->admin();
        $post = factory(Post::class)->create();
        $faker = Factory::create();
        $file = UploadedFile::fake()->image('file.png');

        $this->actingAs($this->admin())
            ->visit("/admin/posts/{$post->slug}/edit")
            ->type($faker->sentence, 'title')
            ->type($faker->paragraph, 'content')
            ->type($faker->datetime->format('Y-m-d\TH:i'), 'posted_at')
            ->attach($file->getPathname(), 'thumbnail')
            ->select($author->id, 'author_id')
            ->press('Mettre à jour')
            ->see('Article mis à jour avec succès');

        Storage::delete(Post::first()->thumbnail()->filename);
    }

    public function testPostUnsetThumbnailLink()
    {
        $post = factory(Post::class)->create();
        $post->storeAndSetThumbnail(UploadedFile::fake()->image('file.png'));

        $this->actingAs($this->admin())
            ->visit("/admin/posts/{$post->slug}/edit")
            ->press("Supprimer l'image à la une")
            ->seeRouteIs('admin.posts.edit', $post)
            ->see('Article mis à jour avec succès');

        Storage::delete($post->thumbnail()->filename);
    }

    public function testPostCreateForm()
    {
        $faker = Factory::create();
        $file = UploadedFile::fake()->image('file.png');
        $author = $this->admin();

        $this->actingAs($this->admin())
            ->visit('/admin/posts/create')
            ->type($faker->sentence, 'title')
            ->type($faker->paragraph, 'content')
            ->select($author->id, 'author_id')
            ->type(Carbon::now()->format('Y-m-d\TH:i'), 'posted_at')
            ->attach($file->getPathname(), 'thumbnail')
            ->press('Sauvegarder')
            ->see('Article créé avec succès');

        Storage::delete(Post::first()->thumbnail()->filename);
    }

    public function testDeletePost()
    {
        $post = factory(Post::class)->create();

        $this->actingAs($this->admin())
            ->visit("/admin/posts/{$post->slug}/edit")
            ->press('Supprimer')
            ->see('Article supprimé avec succès');
    }
}
