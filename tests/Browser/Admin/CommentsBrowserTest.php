<?php

namespace Tests\Browser\Admin;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Post;
use App\Comment;
use Faker\Factory;
use Carbon\Carbon;

class CommentsBrowserTest extends BrowserKitTest
{
    use RefreshDatabase;

    public function testCommentIndexAuthorLink()
    {
        $comments = factory(Comment::class, 10)->create();
        $anakin = factory(User::class)->states('anakin')->create();
        $comment = factory(Comment::class)->create(['author_id' => $anakin->id]);

        $this->actingAs($this->admin())
            ->visit('/admin/comments')
            ->click('Anakin')
            ->seeRouteIs('users.show', $anakin);
    }

    public function testCommentIndexPostLink()
    {
        $post = factory(Post::class)->create(['title' => 'The Empire Strikes Back']);
        $comments = factory(Comment::class, 10)->create();
        $comment = factory(Comment::class)->create(['post_id' => $post->id]);

        $this->actingAs($this->admin())
            ->visit('/admin/comments')
            ->click('The Empire Strikes Back')
            ->seeRouteIs('posts.show', $post);
    }

    public function testUpdateComment()
    {
        $author = factory(User::class)->create();
        $comment = factory(Comment::class)->create();
        $posted_at = Carbon::parse($comment->post->posted_at)->addDay();
        $faker = Factory::create();

        $this->actingAs($this->admin())
            ->visit("/admin/comments/{$comment->id}/edit")
            ->type($faker->paragraph, 'content')
            ->type($posted_at->format('Y-m-d\TH:i'), 'posted_at')
            ->select($author->id, 'author_id')
            ->press('Mettre à jour')
            ->see('Commentaire mis à jour avec succès');
    }

    public function testDeleteComment()
    {
        $comment = factory(Comment::class)->create();

        $this->actingAs($this->admin())
            ->visit("/admin/comments/{$comment->id}/edit")
            ->press('Supprimer')
            ->see('Commentaire supprimé avec succès');
    }
}
