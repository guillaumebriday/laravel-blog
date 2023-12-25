<?php

namespace Tests\Feature\Api\V1;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testPostIndex()
    {
        Post::factory()->count(2)->create();

        $this->json('GET', '/api/v1/posts')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'title',
                    'slug',
                    'content',
                    'posted_at',
                    'author_id',
                    'comments_count'
                ]],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ]
            ]);
    }

    public function testUsersPosts()
    {
        $user = User::factory()->create();
        Post::factory()->create(['author_id' => $user->id]);

        $this->json('GET', "/api/v1/users/{$user->id}/posts")
            ->assertOk()
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'title',
                    'slug',
                    'content',
                    'posted_at',
                    'author_id',
                    'comments_count'
                ]],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ]
            ]);
    }

    public function testUsersPostsFail()
    {
        $user = User::factory()->create();
        Post::factory()->create(['author_id' => $user->id]);

        $this->json('GET', '/api/v1/users/314/posts')
            ->assertNotFound()
            ->assertJson([
                'message' => sprintf('No query results for model [%s] 314', User::class)
            ]);
    }

    public function testPostShow()
    {
        $post = Post::factory()->create([
            'title' => 'The Empire Strikes Back',
            'content' => 'A Star Wars Story'
        ]);
        Comment::factory()->count(2)->create(['post_id' => $post->id]);

        $this->json('GET', "/api/v1/posts/{$post->id}")
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'content',
                    'posted_at',
                    'author_id',
                    'comments_count'
                ],
            ])
            ->assertJson([
                'data' => [
                    'id' => $post->id,
                    'title' => 'The Empire Strikes Back',
                    'slug' => 'the-empire-strikes-back',
                    'content' => 'A Star Wars Story',
                    'posted_at' => $post->posted_at->toIso8601String(),
                    'author_id' => $post->author_id,
                    'comments_count' => 2
                ],
            ]);
    }

    public function testPostShowFail()
    {
        $this->json('GET', '/api/v1/posts/31415')
            ->assertNotFound()
            ->assertJson([
                'message' => sprintf('No query results for model [%s] 31415', Post::class)
            ]);
    }

    public function testUpdate()
    {
        $post = Post::factory()->create();
        $params = $this->validParams();

        $this->actingAsAdmin('sanctum')
            ->json('PATCH', "/api/v1/posts/{$post->id}", $params)
            ->assertOk();

        $post->refresh();

        $this->assertDatabaseHas('posts', $params);
        $this->assertEquals($params['title'], $post->title);
        $this->assertEquals($params['content'], $post->content);
    }

    public function testUpdateFail()
    {
        $post = Post::factory()->create();

        $this->actingAsUser('sanctum')
            ->json('PATCH', "/api/v1/posts/{$post->id}", $this->validParams())
            ->assertForbidden()
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }

    public function testStorePost()
    {
        $params = $this->validParams();

        $this->actingAsAdmin('sanctum')
            ->json('POST', '/api/v1/posts/', $params)
            ->assertCreated();

        $params['posted_at'] = Carbon::yesterday()->second(0)->toDateTimeString();
        $this->assertDatabaseHas('posts', $params);
    }

    public function testStorePostUnauthorized()
    {
        $this->actingAsUser('sanctum')
            ->json('POST', '/api/v1/posts/', $this->validParams())
            ->assertForbidden()
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }

    public function testPostDelete()
    {
        $post = Post::factory()->create();

        $this->actingAsAdmin('sanctum')
            ->json('DELETE', "/api/v1/posts/{$post->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('posts', $post->toArray());
    }

    public function testPostDeleteUnauthorized()
    {
        $post = Post::factory()->create();

        $this->actingAsUser('sanctum')
            ->json('DELETE', "/api/v1/posts/{$post->id}")
            ->assertForbidden()
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);

        $this->assertDatabaseHas('posts', $post->toArray());
    }

    /**
     * Valid params for updating or creating a resource
     */
    private function validParams(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Star Trek ?',
            'content' => 'Star Wars.',
            'posted_at' => Carbon::yesterday()->format('Y-m-d\TH:i'),
            'author_id' => $this->admin()->id,
        ], $overrides);
    }
}
