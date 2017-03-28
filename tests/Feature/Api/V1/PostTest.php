<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use App\Post;
use App\Comment;
use Carbon\Carbon;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it returns a posts collection
     * @return void
     */
    public function testPostIndex()
    {
        $posts = factory(Post::class, 10)->create();
        $response = $this->actingAs($this->user(), 'api')->json('GET', '/api/v1/posts');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'type',
                    'id',
                    'attributes' => [
                        'title',
                        'content',
                        'posted_at',
                        'author_id',
                        'has_thumbnail',
                        'thumbnail_url',
                        'comments_count'
                    ]
                ]],
                'meta' => [
                    'pagination' => [
                        'total'
                    ]
                ],
                'links' => [
                    'self',
                    'first',
                    'last'
                ]
            ])
            ->assertJsonFragment([
                'meta' => [
                    'pagination' => [
                        'count' => 10,
                        'current_page' => 1,
                        'per_page' => 20,
                        'total' => 10,
                        'total_pages' => 1
                    ]
                ]
            ]);
    }

    /**
     * it returns a post item
     * @return void
     */
    public function testPostShow()
    {
        $post = factory(Post::class)->create([
            'title' => 'The Empire Strikes Back',
            'content' => 'A Star Wars Story'
        ]);
        $comment = factory(Comment::class, 5)->create(['post_id' => $post->id]);

        $response = $this->actingAs($this->user(), 'api')->json('GET', "/api/v1/posts/{$post->id}");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'title',
                        'content',
                        'posted_at',
                        'author_id',
                        'has_thumbnail',
                        'thumbnail_url',
                        'comments_count'
                    ]
                ],
            ])
            ->assertJson([
                'data' => [
                    'type' => 'posts',
                    'id' => $post->id,
                    'attributes' => [
                        'title' => 'The Empire Strikes Back',
                        'content' => 'A Star Wars Story',
                        'posted_at' => $post->posted_at->toIso8601String(),
                        'author_id' => $post->author_id,
                        'has_thumbnail' => false,
                        'thumbnail_url' => null,
                        'comments_count' => 5
                    ]
                ],
            ]);
    }

    /**
     * it returns a 404 not found error
     * @return void
     */
    public function testPostShowFail()
    {
        $response = $this->actingAs($this->user(), 'api')->json('GET', '/api/v1/posts/31415');

        $response
            ->assertStatus(404)
            ->assertJson([
                'error' => [
                    'message' => 'Not found.',
                    'status' => 404
                ]
            ]);
    }

    /**
     * it returns a 401 unauthenticated error
     * @return void
     */
    public function testPostShowUnauthenticated()
    {
        $post = factory(Post::class)->create();
        $response = $this->json('GET', "/api/v1/posts/{$post->id}");

        $response
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthenticated.'
            ]);
    }

    /**
     * it stores a new post
     * @return void
     */
    public function testStorePost()
    {
        $user = $this->user();
        $response = $this->actingAs($user, 'api')
                         ->json('POST', '/api/v1/posts/', $this->validParams());

        $response->assertStatus(201);
    }

    /**
     * Valid params for updating or creating a resource
     * @param  array $overrides new params
     * @return array Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Star Trek ?',
            'content' => 'Star Wars.',
            'thumbnail' => UploadedFile::fake()->image('file.png')
        ], $overrides);
    }
}
