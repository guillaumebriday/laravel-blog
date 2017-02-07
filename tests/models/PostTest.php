<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use App\Comment;
use App\User;
use App\Role;
use Faker\Factory;
use Carbon\Carbon;

class PostTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testLimitLastMonthPosts()
    {
        $posts = factory(Post::class, 30)->create();
        $limit = 5;
        $lastPosts = Post::lastMonth($limit)->get();

        $this->assertEquals($limit, $lastPosts->count());
    }

    public function testGettingOnlyLastMonthPosts()
    {
        $faker = Factory::create();

        // Older Posts
        factory(Post::class, 10)
                ->create()
                ->each(function ($post) use ($faker) {
                    $post->posted_at = $faker->dateTimeBetween(Carbon::now()->subMonths(3), Carbon::now()->subMonths(2));
                    $post->save();
                });

        // Newer Posts
        factory(Post::class, 3)
                ->create()
                ->each(function ($post) use ($faker) {
                    $post->posted_at = $faker->dateTimeBetween(Carbon::now()->subWeeks(3), Carbon::now()->subWeeks(1));
                    $post->save();
                });

        $isDuringLastMonth = true;
        foreach (Post::lastMonth()->get() as $post) {
            $isDuringLastMonth = $post->posted_at->between(Carbon::now()->subMonth(), Carbon::now());
        }

        $this->assertTrue($isDuringLastMonth);
    }

    public function testGettingOnlyLastWeekPosts()
    {
        $faker = Factory::create();

        // Older Posts
        factory(Post::class, 10)
                ->create()
                ->each(function ($post) use ($faker) {
                    $post->posted_at = $faker->dateTimeBetween(Carbon::now()->subMonths(3), Carbon::now()->subMonths(2));
                    $post->save();
                });

        // Newer Posts
        factory(Post::class, 3)
                ->create()
                ->each(function ($post) use ($faker) {
                    $post->posted_at = $faker->dateTimeBetween(Carbon::now()->subWeek(), Carbon::now());
                    $post->save();
                });

        $isDuringLastWeek = true;
        foreach (Post::lastWeek()->get() as $post) {
            $isDuringLastWeek = $post->posted_at->between(Carbon::now()->subWeek(), Carbon::now());
        }

        $this->assertTrue($isDuringLastWeek);
    }

    public function testCreatedAt()
    {
        $post = factory(Post::class)->create();
        $this->assertEquals($post->created_at->toDateTimeString(), Carbon::now()->toDateTimeString());
    }

    public function testRelationWithAuthor()
    {
        $post = factory(Post::class)->create();
        $this->assertEquals($post->author_id, $post->author->id);
    }

    public function testRelationWithComments()
    {
        $post = factory(Post::class)->create();
        $comments = factory(Comment::class, 5)->create(['post_id' => $post->id]);

        $comment = factory(Comment::class)->create(['post_id' => $post->id]);

        $this->assertContains($comment->id, $post->comments->pluck('id'));
    }

    public function testPostedAtScopeApplied()
    {
        $older_post = factory(Post::class)->create();
        $older_post->update(['posted_at' => Carbon::yesterday()]);

        $newer_post = factory(Post::class)->create();
        $newer_post->update(['posted_at' => Carbon::tomorrow()]);

        $isBeforeNow = true;
        foreach (Post::all() as $post) {
            $isBeforeNow = $post->posted_at->lt(Carbon::now());
        }

        $this->assertTrue($isBeforeNow);
        $this->assertEquals(1, Post::count());
    }

    public function testPostedAtScopeNotApplied()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());

        $this->actingAs($admin);

        $older_post = factory(Post::class)->create();
        $older_post->update(['posted_at' => Carbon::yesterday()]);

        $newer_post = factory(Post::class)->create();
        $newer_post->update(['posted_at' => Carbon::tomorrow()]);

        $isBeforeNow = true;
        foreach (Post::all() as $post) {
            $isBeforeNow = $post->posted_at->lt(Carbon::now());
        }

        $this->assertFalse($isBeforeNow);
        $this->assertEquals(2, Post::count());
    }
}
