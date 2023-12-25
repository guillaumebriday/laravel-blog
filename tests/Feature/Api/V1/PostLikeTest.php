<?php

namespace Tests\Feature\Api\V1;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostLikeTest extends TestCase
{
    use RefreshDatabase;

    public function testPostLike()
    {
        $post = Post::factory()->create();

        $this->actingAsUser('sanctum')
            ->json('POST', "/api/v1/posts/{$post->id}/likes")
            ->assertCreated();

        $this->assertCount(1, $post->likes);
    }

    public function testPostDislike()
    {
        $user = $this->user();
        $post = Post::factory()->create();
        $post->likes()->create(['author_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->json('DELETE', "/api/v1/posts/{$post->id}/likes")
            ->assertOk();

        $this->assertCount(0, $post->likes);
    }
}
