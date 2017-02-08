<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use App\User;
use App\Role;
use App\Comment;
use Faker\Factory;

class AdminPostsViewsTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testPostIndexShowLink()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $post = factory(Post::class)->create();

        $this->actingAs($admin)
            ->visit(route('admin.posts.index'))
            ->click($post->title)
            ->seeRouteIs('admin.posts.edit', $post);
    }

    public function testPostIndexAuthorLink()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $post = factory(Post::class)->create();

        $this->actingAs($admin)
            ->visit(route('admin.posts.index'))
            ->click(user_name($post->author))
            ->seeRouteIs('users.show', $post->author);
    }

    public function testPostIndexHumanizeDate()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $post = factory(Post::class)->create();

        $this->actingAs($admin)
            ->visit(route('admin.posts.index'))
            ->see(humanize_date($post->posted_at, 'd/m/Y H:i:s'));
    }

    public function testPostEditContent()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $post = factory(Post::class)->create();

        $this->actingAs($admin)
            ->visit(route('admin.posts.edit', $post))
            ->see($post->content)
            ->see($post->title)
            ->see(__('posts.show'));
    }

    public function testPostForm()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $author = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $faker = Factory::create();

        $this->actingAs($admin)
            ->visit(route('admin.posts.edit', $post))
            ->type($faker->sentence, 'title')
            ->type($faker->paragraph, 'content')
            ->type($faker->datetime->format('d/m/Y H:i:s'), 'posted_at')
            ->select($author->id, 'author_id')
            ->press(__('forms.actions.update'))
            ->see(__('posts.updated'));
    }
}
