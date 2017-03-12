<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Comment;
use Faker\Factory;
use Carbon\Carbon;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it fills the created_at field when a comment is posted
     * @return void
     */
    public function testCreatedAt()
    {
        $comment = factory(Comment::class)->create();
        $this->assertEquals($comment->created_at->toDateTimeString(), Carbon::now()->toDateTimeString());
    }

    /**
     * it returns only comments posted last month
     * @return void
     */
    public function testGettingOnlyLastWeekComments()
    {
        $faker = Factory::create();

        // Older Comments
        factory(Comment::class, 10)
                ->create()
                ->each(function ($comment) use ($faker) {
                    $comment->posted_at = $faker->dateTimeBetween(Carbon::now()->subMonths(3), Carbon::now()->subMonths(2));
                    $comment->save();
                });

        // Newer Comments
        factory(Comment::class, 3)
                ->create()
                ->each(function ($comment) use ($faker) {
                    $comment->posted_at = $faker->dateTimeBetween(Carbon::now()->subWeek(), Carbon::now());
                    $comment->save();
                });

        $isDuringLastWeek = true;
        foreach (Comment::lastWeek()->get() as $comment) {
            $isDuringLastWeek = $comment->posted_at->between(Carbon::now()->subWeek(), Carbon::now());
        }

        $this->assertTrue($isDuringLastWeek);
    }
}
