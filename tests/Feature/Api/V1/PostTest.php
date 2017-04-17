<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Comment;
use App\User;
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

        $this->json('GET', '/api/v1/posts')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'type',
                    'id',
                    'attributes' => [
                        'title',
                        'slug',
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
     * it returns a posts collection
     * @return void
     */
    public function testUsersPosts()
    {
        $user = factory(User::class)->create();
        $posts = factory(Post::class, 10)->create(['author_id' => $user->id]);
        $randomPosts = factory(Post::class, 10)->create();

        $this->json('GET', "/api/v1/users/{$user->id}/posts")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'type',
                    'id',
                    'attributes' => [
                        'title',
                        'slug',
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
     * it returns a 404 not found error
     * @return void
     */
    public function testUsersPostsFail()
    {
        $user = factory(User::class)->create();
        $posts = factory(Post::class, 10)->create(['author_id' => $user->id]);

        $this->json('GET', '/api/v1/users/314/posts')
            ->assertStatus(404)
            ->assertJson([
                'error' => [
                    'message' => 'Not found.',
                    'status' => 404
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

        $this->json('GET', "/api/v1/posts/{$post->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'title',
                        'slug',
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
                        'slug' => 'the-empire-strikes-back',
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
        $this->json('GET', '/api/v1/posts/31415')
            ->assertStatus(404)
            ->assertJson([
                'error' => [
                    'message' => 'Not found.',
                    'status' => 404
                ]
            ]);
    }
}
