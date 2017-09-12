<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Comment;
use App\User;
use App\Role;
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

    /**
     * it updates the post
     *
     * @return void
     */
    public function testUpdate()
    {
        $post = factory(Post::class)->create();
        $params = $this->validParams();

        $response = $this->actingAs($this->admin(), 'api')
                         ->json('PATCH', "/api/v1/posts/{$post->id}", $params);

        $post = $post->fresh();

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', array_except($params, 'thumbnail'));
        $this->assertEquals($params['title'], $post->title);
        $this->assertEquals($params['content'], $post->content);

        Storage::delete($post->thumbnail()->filename);
    }

    /**
     * it updates the post
     *
     * @return void
     */
    public function testUpdateFail()
    {
        $post = factory(Post::class)->create();

        $response = $this->actingAs($this->user(), 'api')
                         ->json('PATCH', "/api/v1/posts/{$post->id}", $this->validParams());

        $response
        ->assertStatus(401)
        ->assertJson([
            'error' => [
                'message' => 'Unauthorized.',
                'status' => 401
            ]
        ]);
    }

    /**
     * it unsets the post's thumbnail
     *
     * @return void
     */
    public function testUnsetThumbnail()
    {
        $post = factory(Post::class)->create();
        $post->storeAndSetThumbnail(UploadedFile::fake()->image('file.png'));
        $filename = $post->thumbnail()->filename;

        $response = $this->actingAs($this->admin(), 'api')
                         ->json('DELETE', "/api/v1/posts/{$post->id}/thumbnail", []);

        $post = $post->fresh();

        $response->assertStatus(200);
        $this->assertFalse($post->hasThumbnail());

        Storage::delete($filename);
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
            'posted_at' => Carbon::yesterday()->format('Y-m-d\TH:i'),
            'author_id' => $this->admin()->id,
            'thumbnail' => UploadedFile::fake()->image('file.png')
        ], $overrides);
    }
}
