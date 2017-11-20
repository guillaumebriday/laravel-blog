<?php

namespace Tests\Feature\Admin;

use App\Comment;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

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

        $comment->refresh();

        $response->assertStatus(302);
        $response->assertRedirect("/admin/comments/{$comment->id}/edit");
        $this->assertDatabaseHas('comments', $params);
        $this->assertEquals($params['content'], $comment->content);
    }

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

        $comment->refresh();

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertDatabaseMissing('comments', $params);
    }

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
     *
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
