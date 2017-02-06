<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Comment;
use Carbon\Carbon;
use Faker\Factory;

class CommentTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testCreatedAt()
    {
        $comment = factory(Comment::class)->create();
        $this->assertEquals($comment->created_at->toDateTimeString(), Carbon::now()->toDateTimeString());
    }

    public function testRelationWithAuthor()
    {
        $comment = factory(Comment::class)->create();
        $this->assertEquals($comment->author_id, $comment->author->id);
    }

    public function testRelationWithPost()
    {
        $comment = factory(Comment::class)->create();
        $this->assertEquals($comment->post_id, $comment->post->id);
    }

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
