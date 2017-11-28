<?php

namespace Tests\Feature\Api\V1;

use App\Comment;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testPostIndex()
    {
        factory(Post::class, 2)->create();

        $this->json('GET', '/api/v1/posts')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                        'id',
                        'title',
                        'slug',
                        'content',
                        'posted_at',
                        'author_id',
                        'has_thumbnail',
                        'thumbnail_url',
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
        $user = factory(User::class)->create();
        factory(Post::class)->create(['author_id' => $user->id]);

        $this->json('GET', "/api/v1/users/{$user->id}/posts")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'title',
                    'slug',
                    'content',
                    'posted_at',
                    'author_id',
                    'has_thumbnail',
                    'thumbnail_url',
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
        $user = factory(User::class)->create();
        factory(Post::class)->create(['author_id' => $user->id]);

        $this->json('GET', '/api/v1/users/314/posts')
            ->assertStatus(404)
            ->assertJson([
                'message' => 'No query results for model [App\\User].'
            ]);
    }

    public function testPostShow()
    {
        $post = factory(Post::class)->create([
            'title' => 'The Empire Strikes Back',
            'content' => 'A Star Wars Story'
        ]);
        factory(Comment::class, 2)->create(['post_id' => $post->id]);

        $this->json('GET', "/api/v1/posts/{$post->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'content',
                    'posted_at',
                    'author_id',
                    'has_thumbnail',
                    'thumbnail_url',
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
                    'has_thumbnail' => false,
                    'thumbnail_url' => null,
                    'comments_count' => 2
                ],
            ]);
    }

    public function testPostShowFail()
    {
        $this->json('GET', '/api/v1/posts/31415')
            ->assertStatus(404)
            ->assertJson([
                'message' => 'No query results for model [App\\Post].'
            ]);
    }

    public function testUpdate()
    {
        $post = factory(Post::class)->create();
        $params = $this->validParams();

        $this->actingAs($this->admin(), 'api')
            ->json('PATCH', "/api/v1/posts/{$post->id}", $params)
            ->assertStatus(200);

        $post->refresh();

        $this->assertDatabaseHas('posts', array_except($params, 'thumbnail'));
        $this->assertEquals($params['title'], $post->title);
        $this->assertEquals($params['content'], $post->content);

        Storage::delete($post->thumbnail()->filename);
    }

    public function testUpdateFail()
    {
        $post = factory(Post::class)->create();

        $this->actingAs($this->user(), 'api')
            ->json('PATCH', "/api/v1/posts/{$post->id}", array_except($this->validParams(), 'thumbnail'))
            ->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }

    public function testStorePost()
    {
        $params = array_except($this->validParams(), 'thumbnail');

        $this->actingAs($this->admin(), 'api')
            ->json('POST', '/api/v1/posts/', $params)
            ->assertStatus(201);

        $params['posted_at'] = Carbon::yesterday()->second(0)->toDateTimeString();
        $this->assertDatabaseHas('posts', $params);
    }

    public function testStorePostUnauthorized()
    {
        $this->actingAs($this->user(), 'api')
            ->json('POST', '/api/v1/posts/', array_except($this->validParams(), 'thumbnail'))
            ->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);
    }

    public function testUnsetThumbnail()
    {
        $post = factory(Post::class)->create();
        $post->storeAndSetThumbnail(UploadedFile::fake()->image('file.png'));
        $filename = $post->thumbnail()->filename;

        $this->actingAs($this->admin(), 'api')
            ->json('DELETE', "/api/v1/posts/{$post->id}/thumbnail", [])
            ->assertStatus(200);

        $post->refresh();
        $this->assertFalse($post->hasThumbnail());

        Storage::delete($filename);
    }

    public function testPostDelete()
    {
        $post = factory(Post::class)->create();

        $this->actingAs($this->admin(), 'api')
            ->json('DELETE', "/api/v1/posts/{$post->id}")
            ->assertStatus(204);

        $this->assertDatabaseMissing('posts', $post->toArray());
    }

    public function testPostDeleteUnauthorized()
    {
        $post = factory(Post::class)->create();

        $this->actingAs($this->user(), 'api')
            ->json('DELETE', "/api/v1/posts/{$post->id}")
            ->assertStatus(403)
            ->assertJson([
                'message' => 'This action is unauthorized.'
            ]);

        $this->assertDatabaseHas('posts', $post->toArray());
    }

    /**
     * Valid params for updating or creating a resource
     *
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
