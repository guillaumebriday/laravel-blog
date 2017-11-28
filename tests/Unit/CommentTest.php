<?php

namespace Tests\Unit;

use App\Comment;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testPostedAt()
    {
        $comment = factory(Comment::class)->create();
        $this->assertEquals($comment->posted_at->toDateTimeString(), Carbon::now()->toDateTimeString());
    }

    public function testGettingOnlyLastWeekComments()
    {
        $faker = Factory::create();

        // Older Comments
        factory(Comment::class, 3)
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

            if (! $isDuringLastWeek) {
                break;
            }
        }

        $this->assertTrue($isDuringLastWeek);
    }
}
