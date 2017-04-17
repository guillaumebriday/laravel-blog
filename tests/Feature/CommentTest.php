<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use App\Comment;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it stores a new comment
     * @return void
     */
    public function testStore()
    {
        $params = $this->validParams();

        $response = $this->actingAs($this->user())
                         ->post('/comments', $params);

        $response->assertStatus(302);
        $this->assertDatabaseHas('comments', $params);
    }

    /**
     * it returns errors when param's missing
     * @return void
     */
    public function testStoreFail()
    {
        $response = $this->actingAs($this->user())
                         ->post('/comments', $this->validParams([
                             'content' => null
                         ]));

        $response->assertStatus(302)
                 ->assertSessionHas('errors');
    }

    /**
     * it deletes requested comment
     * @return void
     */
    public function testDelete()
    {
        $user = $this->user();
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create([
            'author_id' => $user->id,
            'post_id' => $post->id
        ]);

        $response = $this->actingAs($user)
                         ->delete("/comments/{$comment->id}");

        $response->assertRedirect("/posts/{$post->slug}");
        $this->assertDatabaseMissing('comments', $comment->toArray());
    }

    /**
     * it does not delete requested comment
     * @return void
     */
    public function testDeleteForbidden()
    {
        $comment = factory(Comment::class)->create();

        $response = $this->actingAs($this->user())
                         ->delete("/comments/{$comment->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('comments', $comment->toArray());
    }

    /**
     * Valid params for updating or creating a resource
     * @param  array $overrides new params
     * @return array Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        return array_merge([
            'post_id' => factory(Post::class)->create()->id,
            'content' => 'Great article ! Thanks for sharing it with us.'
        ], $overrides);
    }
}
