<?php

namespace Tests\Unit;

use App\Comment;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testPostedAt()
    {
        $comment = factory(Comment::class)->create();
        $this->assertEquals($comment->posted_at->toDateTimeString(), now()->toDateTimeString());
    }

    public function testGettingOnlyLastWeekComments()
    {
        $faker = Factory::create();

        // Older Comments
        factory(Comment::class, 3)
                ->create()
                ->each(function ($comment) use ($faker) {
                    $comment->posted_at = $faker->dateTimeBetween(now()->subMonths(3), now()->subMonths(2));
                    $comment->save();
                });

        // Newer Comments
        factory(Comment::class, 3)
                ->create()
                ->each(function ($comment) use ($faker) {
                    $comment->posted_at = $faker->dateTimeBetween(now()->subWeek(), now());
                    $comment->save();
                });

        $isDuringLastWeek = true;
        foreach (Comment::lastWeek()->get() as $comment) {
            $isDuringLastWeek = $comment->posted_at->between(now()->subWeek(), now());

            if (! $isDuringLastWeek) {
                break;
            }
        }

        $this->assertTrue($isDuringLastWeek);
    }
}
