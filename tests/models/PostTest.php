<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Post;
use App\Comment;
use Faker\Factory;
use Carbon\Carbon;

class PostTest extends TestCase
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

    public function testCreatedAt()
    {
        $post = factory(Post::class)->create();
        $this->assertEquals($post->created_at, Carbon::now());
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
}
