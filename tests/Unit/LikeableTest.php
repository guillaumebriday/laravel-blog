<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;
use App\Like;

class LikeableTest extends TestCase
{
    use RefreshDatabase;

    public function testLikes()
    {
        $post = factory(Post::class)->create();
        $likes = factory(Like::class, 5)->create(['likeable_id' => $post->id]);

        $this->assertCount(5, $post->likes);
    }

    public function testLike()
    {
        $this->actingAs($this->user());
        $post = factory(Post::class)->create();

        $post->like();

        $this->assertCount(1, $post->likes);
    }

    public function testDislike()
    {
        $this->actingAs($this->user());
        $post = factory(Post::class)->create();

        $post->like();
        $post->dislike();

        $this->assertCount(0, $post->likes);
    }

    public function testIsLiked()
    {
        $this->actingAs($this->user());
        $post = factory(Post::class)->create();

        $post->like();

        $this->assertTrue($post->isLiked());
    }

    public function testIsNotLiked()
    {
        $this->actingAs($this->user());
        $post = factory(Post::class)->create();

        $this->assertFalse($post->isLiked());
    }
}
