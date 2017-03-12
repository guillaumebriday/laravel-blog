<?php

namespace Tests\Browser;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use App\Comment;
use Faker\Factory;

class CommentsBrowserTest extends BrowserKitTest
{
    use DatabaseMigrations;

    /**
     * it clicks on a comment's delete link in post view
     * @return void
     */
    public function testCommentFormDelete()
    {
        $user = $this->user();
        $comment = factory(Comment::class)->create(['author_id' => $user->id]);

        $this->actingAs($user)
            ->visit("/posts/{$comment->post->id}")
            ->press('submit')
            ->see('Commentaire supprimé avec succès');
    }

    /**
     * it creates a comment through create form
     * @return void
     */
    public function testCommentCreateForm()
    {
        $post = factory(Post::class)->create();
        $faker = Factory::create();

        $this->actingAs($this->user())
             ->visit("/posts/{$post->id}")
             ->type($faker->paragraph, 'content')
             ->press('Commenter')
             ->see('Commentaire créé avec succès');
    }
}
