<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Media;
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
     * it fills the posted_at field when a post is posted
     * @return void
     */
    public function testPostedAt()
    {
        $post = factory(Post::class)->create();
        $this->assertEquals($post->posted_at->toDateTimeString(), Carbon::now()->toDateTimeString());
    }

    /**
     * it fills the slug field when a post is being saved
     * @return void
     */
    public function testSlug()
    {
        $post = factory(Post::class)->create(['title' => 'The Empire Strikes Back']);
        $this->assertEquals($post->slug, 'the-empire-strikes-back');
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

            if (! $isDuringLastMonth) {
                break;
            }
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

            if (! $isDuringLastWeek) {
                break;
            }
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

            if (! $isBeforeNow) {
                break;
            }
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

            if (! $isBeforeNow) {
                break;
            }
        }

        $this->assertFalse($isBeforeNow);
        $this->assertEquals(2, Post::count());
    }

    /**
     * it checks if post has thumbnail
     * @return void
     */
    public function testHasThumbnail()
    {
        $post = factory(Post::class)->create();
        $media = factory(Media::class)->states('thumbnail')->create(['mediable_id' => $post->id]);

        $post->update(['thumbnail_id' => $media->id]);

        $this->assertTrue($post->hasThumbnail());
    }

    /**
     * it retrieves the post's thumbnail
     * @return void
     */
    public function testPostsThumbnail()
    {
        $post = factory(Post::class)->create();
        $media = factory(Media::class)->states('thumbnail')->create(['mediable_id' => $post->id]);

        $post->update(['thumbnail_id' => $media->id]);

        $this->assertTrue(is_a($post->thumbnail(), 'App\Media'));
        $this->assertEquals($post->thumbnail()->id, $media->id);
    }

    /**
     * it stores and set the uploaded post's thumbnail
     * @return void
     */
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
