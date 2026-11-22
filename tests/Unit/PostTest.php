<?php

namespace Tests\Unit;

use App\Models\Post;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_limit_last_month_posts()
    {
        $limit = 5;
        Post::factory()->count(6)->create();
        $lastPosts = Post::lastMonth($limit)->get();

        $this->assertEquals($limit, $lastPosts->count());
    }

    public function test_slug()
    {
        $post = Post::factory()->create(['title' => 'The Empire Strikes Back']);
        $this->assertEquals($post->slug, 'the-empire-strikes-back');
    }

    public function test_getting_only_last_month_posts()
    {
        $faker = Factory::create();

        // Older Posts
        Post::factory()
            ->count(3)
            ->create()
            ->each(function ($post) use ($faker) {
                $post->posted_at = $faker->dateTimeBetween(carbon('3 months ago'), carbon('2 months ago'));
                $post->save();
            });

        // Newer Posts
        Post::factory()
            ->count(3)
            ->create()
            ->each(function ($post) use ($faker) {
                $post->posted_at = $faker->dateTimeBetween(carbon('3 weeks ago'), carbon('1 weeks ago'));
                $post->save();
            });

        $isDuringLastMonth = true;
        foreach (Post::lastMonth()->get() as $post) {
            $isDuringLastMonth = $post->posted_at->between(carbon('1 month ago'), now());

            if (!$isDuringLastMonth) {
                break;
            }
        }

        $this->assertTrue($isDuringLastMonth);
    }

    public function test_getting_only_last_week_posts()
    {
        $faker = Factory::create();

        // Older Posts
        Post::factory()
            ->count(3)
            ->create()
            ->each(function ($post) use ($faker) {
                $post->posted_at = $faker->dateTimeBetween(carbon('3 months ago'), carbon('2 months ago'));
                $post->save();
            });

        // Newer Posts
        Post::factory()
            ->count(3)
            ->create()
            ->each(function ($post) use ($faker) {
                $post->posted_at = $faker->dateTimeBetween(carbon('1 week ago'), now());
                $post->save();
            });

        $isDuringLastWeek = true;
        foreach (Post::lastWeek()->get() as $post) {
            $isDuringLastWeek = $post->posted_at->between(carbon('1 week ago'), now());

            if (!$isDuringLastWeek) {
                break;
            }
        }

        $this->assertTrue($isDuringLastWeek);
    }

    public function test_posted_at_scope_applied()
    {
        Post::factory()->create()->update(['posted_at' => carbon('yesterday')]);
        Post::factory()->create()->update(['posted_at' => carbon('tomorrow')]);

        $isBeforeNow = true;
        foreach (Post::all() as $post) {
            $isBeforeNow = $post->posted_at->lt(now());

            if (!$isBeforeNow) {
                break;
            }
        }

        $this->assertTrue($isBeforeNow);
        $this->assertEquals(1, Post::count());
    }

    public function test_posted_at_scope_not_applied()
    {
        $this->actingAsAdmin();

        Post::factory()->create()->update(['posted_at' => carbon('yesterday')]);
        Post::factory()->create()->update(['posted_at' => carbon('tomorrow')]);

        $isBeforeNow = true;
        foreach (Post::all() as $post) {
            $isBeforeNow = $post->posted_at->lt(now());

            if (!$isBeforeNow) {
                break;
            }
        }

        $this->assertFalse($isBeforeNow);
        $this->assertEquals(2, Post::count());
    }

    public function test_search()
    {
        Post::factory()->create(['title' => 'Hello Luke']);
        Post::factory()->create(['title' => 'Hello Leia']);

        $this->assertCount(0, Post::search('Hi Anakin')->get());
        $this->assertCount(1, Post::search('Hello Lu')->get());
        $this->assertCount(2, Post::search('Hello')->get());
    }
}
