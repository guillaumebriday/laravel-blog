<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use App\User;
use App\Comment;
use Faker\Factory;

class PostsViewsTest extends TestCase
{
    use DatabaseMigrations;

    public function testPostIndexShowLink()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $this->actingAs($user)
            ->visit('/')
            ->click($post->title)
            ->seeRouteIs('posts.show', $post);
    }

    public function testPostIndexAuthorLink()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $this->actingAs($user)
            ->visit('/')
            ->click(user_name($post->author))
            ->seeRouteIs('users.show', $post->author);
    }

    public function testPostIndexHumanizeDate()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $this->actingAs($user)
            ->visit('/')
            ->see(humanize_date($post->posted_at));
    }

    public function testPostIndexContent()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $this->actingAs($user)
            ->visit('/')
            ->see($post->content);
    }

    public function testPostShowContent()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $this->actingAs($user)
            ->visit(route('posts.show', $post))
            ->see($post->content);
    }

    public function testPostShowHumanizeDate()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $this->actingAs($user)
            ->visit(route('posts.show', $post))
            ->see(humanize_date($post->posted_at));
    }

    public function testPostShowComments()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $comments = factory(Comment::class, 10)->create(['post_id' => $post->id]);

        $this->actingAs($user)
            ->visit(route('posts.show', $post))
            ->see(trans_choice('comments.count', $comments->count()));
    }

    public function testPostCreate()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit(route('posts.create'))
            ->see(trans('posts.add_article'));
    }

    public function testPostForm()
    {
        $user = factory(User::class)->create();
        $faker = Factory::create();

        $this->actingAs($user)
            ->visit(route('posts.create'))
            ->type($faker->sentence, 'title')
            ->type($faker->paragraph, 'content')
            ->press(trans('posts.publish'))
            ->see(trans('posts.created'));
    }
}
