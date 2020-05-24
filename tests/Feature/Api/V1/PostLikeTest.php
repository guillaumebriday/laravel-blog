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
        $post = factory(Post::class)->create();

        $this->actingAsUser('api')
            ->json('POST', "/api/v1/posts/{$post->id}/likes")
            ->assertCreated();

        $this->assertCount(1, $post->likes);
    }

    public function testPostDislike()
    {
        $user = $this->user();
        $post = factory(Post::class)->create();
        $post->likes()->create(['author_id' => $user->id]);

        $this->actingAs($user, 'api')
            ->json('DELETE', "/api/v1/posts/{$post->id}/likes")
            ->assertOk();

        $this->assertCount(0, $post->likes);
    }
}
