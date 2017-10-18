<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Media;
use App\Post;
use Faker\Factory;
use Carbon\Carbon;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testLimitLastMonthPosts()
    {
        $limit = 5;
        $posts = factory(Post::class, 30)->create();
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
            $isBeforeNow = $post->posted_at->lt(Carbon::now());

            if (! $isBeforeNow) {
                break;
            }
        }

        $this->assertTrue($isBeforeNow);
        $this->assertEquals(1, Post::count());
    }

    public function testPostedAtScopeNotApplied()
    {
        $this->actingAs($this->admin());

        factory(Post::class)->create()->update(['posted_at' => Carbon::yesterday()]);
        factory(Post::class)->create()->update(['posted_at' => Carbon::tomorrow()]);

        $isBeforeNow = true;
        foreach (Post::all() as $post) {
            $isBeforeNow = $post->posted_at->lt(Carbon::now());

            if (! $isBeforeNow) {
                break;
            }
        }

        $this->assertFalse($isBeforeNow);
        $this->assertEquals(2, Post::count());
    }

    public function testHasThumbnail()
    {
        $post = factory(Post::class)->create();
        $media = factory(Media::class)->states('thumbnail')->create(['mediable_id' => $post->id]);

        $post->update(['thumbnail_id' => $media->id]);

        $this->assertTrue($post->hasThumbnail());
    }

    public function testPostsThumbnail()
    {
        $post = factory(Post::class)->create();
        $media = factory(Media::class)->states('thumbnail')->create(['mediable_id' => $post->id]);

        $post->update(['thumbnail_id' => $media->id]);

        $this->assertTrue(is_a($post->thumbnail(), 'App\Media'));
        $this->assertEquals($post->thumbnail()->id, $media->id);
    }

    public function testStoreAndSetThumbnail()
    {
        $post = factory(Post::class)->create();
        $thumbnail = UploadedFile::fake()->image('file.png');

        $post->storeAndSetThumbnail($thumbnail);

        $this->assertTrue($post->hasThumbnail());
        $this->assertTrue(Storage::disk('local')->exists($post->thumbnail()->filename));
        $this->assertEquals($post->thumbnail()->original_filename, 'file.png');

        Storage::delete($post->thumbnail()->filename);
    }
}
