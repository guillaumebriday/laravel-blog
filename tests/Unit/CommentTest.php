<?php

namespace Tests\Unit;

use App\Models\Comment;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testPostedAt()
    {
        $comment = Comment::factory()->create();
        $this->assertEqualsWithDelta($comment->posted_at->timestamp, now()->timestamp, 1);
    }

    public function testGettingOnlyLastWeekComments()
    {
        $faker = Factory::create();

        // Older Comments
        Comment::factory()
            ->count(3)
            ->create()
            ->each(function ($comment) use ($faker) {
                $comment->posted_at = $faker->dateTimeBetween(carbon('3 months ago'), carbon('2 months ago'));
                $comment->save();
            });

        // Newer Comments
        Comment::factory()
            ->count(3)
            ->create()
            ->each(function ($comment) use ($faker) {
                $comment->posted_at = $faker->dateTimeBetween(carbon('1 week ago'), now());
                $comment->save();
            });

        $isDuringLastWeek = true;
        foreach (Comment::lastWeek()->get() as $comment) {
            $isDuringLastWeek = $comment->posted_at->between(carbon('1 week ago'), now());

            if (!$isDuringLastWeek) {
                break;
            }
        }

        $this->assertTrue($isDuringLastWeek);
    }
}
