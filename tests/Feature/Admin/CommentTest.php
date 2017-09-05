<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Post;
use App\Role;
use App\Comment;
use Carbon\Carbon;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it renders admin comments index view
     * @return void
     */
    public function testIndex()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        $comment = factory(Comment::class)->create(['author_id' => $anakin->id]);

        $response = $this->actingAs($this->admin())
                         ->get('/admin/comments');

        $response->assertStatus(200)
                 ->assertSee('1 commentaire')
                 ->assertSee('Anakin')
                 ->assertSee('Contenu')
                 ->assertSee('Auteur')
                 ->assertSee('Posté le')
                 ->assertSee(e($comment->content));
    }

    /**
     * it renders admin comments edit view
     * @return void
     */
    public function testEdit()
    {
        $anakin = factory(User::class)->states('anakin')->create();
        $comment = factory(Comment::class)->create(['author_id' => $anakin->id]);

        $response = $this->actingAs($this->admin())->get("/admin/comments/{$comment->id}/edit");

        $response->assertStatus(200)
                 ->assertSee('Anakin')
                 ->assertSee("Commentaire sur l'article :")
                 ->assertSee(e($comment->post->title))
                 ->assertSee('Contenu')
                 ->assertSee(e($comment->content))
                 ->assertSee('Post&eacute; le')
                 ->assertSee(humanize_date($comment->posted_at, 'Y-m-d\TH:i'))
                 ->assertSee('Mettre à jour')
                 ->assertSee('Supprimer');
    }

    /**
     * it updates requested comment in admin dashboard
     * @return void
     */
    public function testUpdate()
    {
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create(['post_id' => $post->id]);
        $params = $this->validParams([
            'post_id' => $post->id,
            'posted_at' => $post->posted_at->addDay()->format('Y-m-d\TH:i')
        ]);

        $response = $this->actingAs($this->admin())
                         ->patch("/admin/comments/{$comment->id}", $params);

        $comment = $comment->fresh();

        $response->assertStatus(302);
        $response->assertRedirect("/admin/comments/{$comment->id}/edit");
        $this->assertDatabaseHas('comments', $params);
        $this->assertEquals($params['content'], $comment->content);
    }

    /**
     * it does not update requested comment in admin dashboard
     * @return void
     */
    public function testUpdateFail()
    {
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create(['post_id' => $post->id]);
        $params = $this->validParams([
            'post_id' => $post->id,
            'posted_at' => $post->posted_at->subDay()->format('Y-m-d\TH:i')
        ]);

        $response = $this->actingAs($this->admin())
                         ->patch("/admin/comments/{$comment->id}", $params);

        $comment = $comment->fresh();

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertDatabaseMissing('comments', $params);
    }

    /**
     * it deletes requested comment in admin dashboard
     * @return void
     */
    public function testDelete()
    {
        $comment = factory(Comment::class)->create();

        $response = $this->actingAs($this->admin())
                         ->delete("/admin/comments/{$comment->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('comments', $comment->toArray());
        $this->assertTrue(Comment::all()->isEmpty());
    }

    /**
     * Valid params for updating or creating a resource
     * @param  array $overrides new params
     * @return array Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        $post = factory(Post::class)->create();

        return array_merge([
            'content' => "Great article ! Thanks for sharing it with us.",
            'posted_at' => $post->posted_at->addDay()->format('Y-m-d\TH:i'),
            'post_id' => $post->id,
            'author_id' => factory(User::class)->create()->id,
        ], $overrides);
    }
}
