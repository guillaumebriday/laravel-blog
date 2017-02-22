<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Role;
use App\Comment;
use Carbon\Carbon;

class AdminCommentsControllerTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testIndex()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $comments = factory(Comment::class, 10)->create();

        $response = $this->actingAs($admin)->call('GET', route('admin.comments.index'));

        $this->assertResponseOk();
        $this->assertViewHas('comments');
    }

    public function testEdit()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $comment = factory(Comment::class)->create();

        $response = $this->actingAs($admin)->call('GET', route('admin.comments.edit', $comment->first()));
        $this->assertResponseOk();
        $this->assertViewHas('comment');
        $this->assertViewHas('users');
    }

    public function testUpdate()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $author = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $format = 'd/m/Y H:i:s';

        $params = [
            'content' => "I'm a content",
            'posted_at' => Carbon::tomorrow()->format($format),
            'author_id' => $author->id,
        ];

        $response = $this->actingAs($admin)->call('PUT', route('admin.comments.update', $comment), $params);

        $comment = $comment->fresh();
        $params['posted_at'] = Carbon::createFromFormat($format, $params['posted_at']);

        $this->seeInDatabase('comments', $params);
        $this->assertEquals($params['content'], $comment->content);
        $this->assertResponseStatus('302');
    }

    public function testUpdateFail()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $author = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $format = 'd/m/Y H:i:s';

        $params = [
            'content' => "I'm a new content",
            'posted_at' => Carbon::yesterday()->format($format),
            'author_id' => $author->id,
        ];

        $response = $this->actingAs($admin)->call('PUT', route('admin.comments.update', $comment), $params);

        $comment = $comment->fresh();

        $params['posted_at'] = Carbon::createFromFormat($format, $params['posted_at']);

        $this->notSeeInDatabase('comments', $params);
        $this->assertSessionHasErrors('posted_at');
        $this->assertResponseStatus('302');
    }

    public function testDelete()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $comment = factory(Comment::class)->create();

        $response = $this->actingAs($admin)->call('DELETE', route('admin.comments.destroy', $comment));

        $this->notSeeInDatabase('comments', $comment->toArray());
        $this->assertRedirectedToRoute('admin.comments.index');
    }
}
