<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use Faker\Factory;
use Carbon\Carbon;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it returns only the right number of posts
     * @return void
     */
    public function testLimitLastMonthPosts()
    {
        $limit = 5;
        $posts = factory(Post::class, 30)->create();
        $lastPosts = Post::lastMonth($limit)->get();

        $this->assertEquals($limit, $lastPosts->count());
    }

    /**
     * it fills the created_at field when a post is posted
     * @return void
     */
    public function testCreatedAt()
    {
        $post = factory(Post::class)->create();
        $this->assertEquals($post->created_at->toDateTimeString(), Carbon::now()->toDateTimeString());
    }

    /**
     * it returns only posts posted last month
     * @return void
     */
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

    /**
     * it returns only posts posted last week
     * @return void
     */
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

    /**
     * it returns only posts posted before now
     * @return void
     */
    public function testPostedAtScopeApplied()
    {
        factory(Post::class)->create()->update(['posted_at' => Carbon::yesterday()]);
        factory(Post::class)->create()->update(['posted_at' => Carbon::tomorrow()]);

        $isBeforeNow = true;
        foreach (Post::all() as $post) {
            $isBeforeNow = $post->posted_at->lt(Carbon::now());
        }

        $this->assertTrue($isBeforeNow);
        $this->assertEquals(1, Post::count());
    }

    /**
     * it does not return only posts posted before now if user is an admin
     * @return void
     */
    public function testPostedAtScopeNotApplied()
    {
        $this->actingAs($this->admin());

        factory(Post::class)->create()->update(['posted_at' => Carbon::yesterday()]);
        factory(Post::class)->create()->update(['posted_at' => Carbon::tomorrow()]);

        $isBeforeNow = true;
        foreach (Post::all() as $post) {
            $isBeforeNow = $post->posted_at->lt(Carbon::now());
        }

        $this->assertFalse($isBeforeNow);
        $this->assertEquals(2, Post::count());
    }
}
