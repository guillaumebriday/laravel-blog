<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;
use App\Comment;

class CommentsControllerTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testStore()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $params = [
            'post_id' => $post->id,
            'content' => 'hello world'
        ];

        $response = $this->actingAs($user)->call('POST', route('comments.store'), $params);

        $this->seeInDatabase('comments', $params);
        $this->assertResponseStatus('302');
    }

    public function testStoreFail()
    {
        $user = factory(User::class)->create();
        $params = [ 'content' => 'hello world' ];

        $response = $this->actingAs($user)->call('POST', route('comments.store'), $params);

        $this->assertResponseStatus('404');
    }

    public function testDestroy()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create(['author_id' => $user->id]);
        $params = [ 'id' => $comment->id ];

        $response = $this->actingAs($user)->call('DELETE', route('comments.destroy', $params));

        $this->notSeeInDatabase('comments', $params);
        $this->assertRedirectedToRoute('posts.show', ['id' => $comment->post_id]);
    }

    public function testDestroyFail()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();
        $params = [ 'id' => $comment->id ];

        $response = $this->actingAs($user)->call('DELETE', route('comments.destroy', $params));

        $this->seeInDatabase('comments', $params);
        $this->assertResponseStatus('403');
    }
}
