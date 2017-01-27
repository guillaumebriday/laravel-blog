<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use App\User;
use App\Comment;
use Faker\Factory;

class CommentsViewsTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testCommentContent()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->actingAs($user)
            ->visit(route('posts.show', $comment->post))
            ->see($comment->content);
    }

    public function testCommentHumanizeDate()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->actingAs($user)
            ->visit(route('posts.show', $comment->post))
            ->see(humanize_date($comment->posted_at));
    }

    public function testCommentFormDelete()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create(['author_id' => $user->id]);

        $this->actingAs($user)
            ->visit(route('posts.show', $comment->post))
            ->press('submit')
            ->see(trans('comments.deleted'));
    }

    public function testCommentFormStore()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $faker = Factory::create();

        $this->actingAs($user)
            ->visit(route('posts.show', $post))
            ->type($faker->paragraph, 'content')
            ->press(trans('comments.comment'))
            ->see(trans('comments.created'));
    }

    public function testCommentShowInUserProfil()
    {
        $user = factory(User::class)->create();
        $comment = factory(Post::class)->create(['author_id' => $user->id]);
        $faker = Factory::create();

        $this->actingAs($user)
            ->visit(route('users.show', $user))
            ->see($comment->content);
    }
}
