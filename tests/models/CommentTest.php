<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Comment;
use Carbon\Carbon;

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
}
