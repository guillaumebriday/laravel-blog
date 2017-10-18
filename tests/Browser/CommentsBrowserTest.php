<?php

namespace Tests\Browser;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;
use App\Comment;
use Faker\Factory;

class CommentsBrowserTest extends BrowserKitTest
{
    use RefreshDatabase;

    public function testCommentFormDelete()
    {
        $user = $this->user();
        $comment = factory(Comment::class)->create(['author_id' => $user->id]);

        $this->actingAs($user)
            ->visit("/posts/{$comment->post->slug}")
            ->press('×')
            ->see('Commentaire supprimé avec succès');
    }

    public function testCommentCreateForm()
    {
        $post = factory(Post::class)->create();
        $faker = Factory::create();

        $this->actingAs($this->user())
             ->visit("/posts/{$post->slug}")
             ->type($faker->paragraph, 'content')
             ->press('Commenter')
             ->see('Commentaire créé avec succès');
    }
}
