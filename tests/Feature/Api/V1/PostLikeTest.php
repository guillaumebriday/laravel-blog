<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Comment;
use App\User;
use App\Role;
use Carbon\Carbon;

class PostLikeTest extends TestCase
{
    use RefreshDatabase;

    public function testPostLike()
    {
        $post = factory(Post::class)->create();

        $this->actingAs($this->user(), 'api')
            ->json('POST', "/api/v1/posts/{$post->id}/likes")
            ->assertStatus(200);

        $this->assertCount(1, $post->likes);
    }

    public function testPostDislike()
    {
        $user = $this->user();
        $post = factory(Post::class)->create();
        $post->likes()->create(['author_id' => $user->id]);

        $this->actingAs($user, 'api')
            ->json('DELETE', "/api/v1/posts/{$post->id}/likes")
            ->assertStatus(200);

        $this->assertCount(0, $post->likes);
    }
}
