<?php

namespace Tests\Unit;

use App\Models\Post;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testLimitLastMonthPosts()
    {
        $limit = 5;
        factory(Post::class, 6)->create();
        $lastPosts = Post::lastMonth($limit)->get();

        $this->assertEquals($limit, $lastPosts->count());
    }

    public function testSlug()
    {
        $post = factory(Post::class)->create(['title' => 'The Empire Strikes Back']);
        $this->assertEquals($post->slug, 'the-empire-strikes-back');
    }

    public function testGettingOnlyLastMonthPosts()
    {
        $faker = Factory::create();

        // Older Posts
        factory(Post::class, 3)
                ->create()
                ->each(function ($post) use ($faker) {
                    $post->posted_at = $faker->dateTimeBetween(now()->subMonths(3), now()->subMonths(2));
                    $post->save();
                });

        // Newer Posts
        factory(Post::class, 3)
                ->create()
                ->each(function ($post) use ($faker) {
                    $post->posted_at = $faker->dateTimeBetween(now()->subWeeks(3), now()->subWeeks(1));
                    $post->save();
                });

        $isDuringLastMonth = true;
        foreach (Post::lastMonth()->get() as $post) {
            $isDuringLastMonth = $post->posted_at->between(now()->subMonth(), now());

            if (! $isDuringLastMonth) {
                break;
            }
        }

        $this->assertTrue($isDuringLastMonth);
    }

    public function testGettingOnlyLastWeekPosts()
    {
        $faker = Factory::create();

        // Older Posts
        factory(Post::class, 3)
                ->create()
                ->each(function ($post) use ($faker) {
                    $post->posted_at = $faker->dateTimeBetween(now()->subMonths(3), now()->subMonths(2));
                    $post->save();
                });

        // Newer Posts
        factory(Post::class, 3)
                ->create()
                ->each(function ($post) use ($faker) {
                    $post->posted_at = $faker->dateTimeBetween(now()->subWeek(), now());
                    $post->save();
                });

        $isDuringLastWeek = true;
        foreach (Post::lastWeek()->get() as $post) {
            $isDuringLastWeek = $post->posted_at->between(now()->subWeek(), now());

            if (! $isDuringLastWeek) {
                break;
            }
        }

        $this->assertTrue($isDuringLastWeek);
    }

    public function testPostedAtScopeApplied()
    {
        factory(Post::class)->create()->update(['posted_at' => Carbon::yesterday()]);
        factory(Post::class)->create()->update(['posted_at' => Carbon::tomorrow()]);

        $isBeforeNow = true;
        foreach (Post::all() as $post) {
            $isBeforeNow = $post->posted_at->lt(now());

            if (! $isBeforeNow) {
                break;
            }
        }

        $this->assertTrue($isBeforeNow);
        $this->assertEquals(1, Post::count());
    }

    public function testPostedAtScopeNotApplied()
    {
        $this->actingAsAdmin();

        factory(Post::class)->create()->update(['posted_at' => Carbon::yesterday()]);
        factory(Post::class)->create()->update(['posted_at' => Carbon::tomorrow()]);

        $isBeforeNow = true;
        foreach (Post::all() as $post) {
            $isBeforeNow = $post->posted_at->lt(now());

            if (! $isBeforeNow) {
                break;
            }
        }

        $this->assertFalse($isBeforeNow);
        $this->assertEquals(2, Post::count());
    }

    public function testSearch()
    {
        factory(Post::class)->create(['title' => 'Hello Luke']);
        factory(Post::class)->create(['title' => 'Hello Leia']);

        $this->assertCount(0, Post::search('Hi Anakin')->get());
        $this->assertCount(1, Post::search('Hello Lu')->get());
        $this->assertCount(2, Post::search('Hello')->get());
    }
}
