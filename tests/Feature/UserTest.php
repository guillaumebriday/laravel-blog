<?php

namespace Tests\Feature;

use App\Comment;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testProfil()
    {
        $user = $this->user();
        $comment = factory(Comment::class)->create(['author_id' => $user->id]);
        $posts = factory(Post::class, 3)->create(['author_id' => $user->id]);

        $this->actingAs($user)
            ->get("/users/{$user->id}")
            ->assertStatus(200)
            ->assertSee(e($user->name))
            ->assertSee(e($user->email))
            ->assertSee('Commentaires')
            ->assertSee('Articles')
            ->assertSee('3')
            ->assertSee("J'aime")
            ->assertSee('Commentaires')
            ->assertSee('Les derniers commentaires')
            ->assertSee($comment->content)
            ->assertSee('Les derniers articles')
            ->assertSee($posts->first()->title)
            ->assertSee('&Eacute;diter le profil');
    }

    public function testEditing()
    {
        $user = $this->user();

        $this->actingAs($user)
            ->get('/settings/account')
            ->assertStatus(200)
            ->assertSee('Mon profil')
            ->assertSee('Mon profil public')
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee('Sécurité')
            ->assertSee('Sauvegarder');
    }

    public function testUpdate()
    {
        $user = $this->user();
        $params = $this->validParams();

        $this->actingAs($user)
            ->patch('/settings/account', $params)
            ->assertStatus(302)
            ->assertRedirect('/settings/account');

        $user->refresh();
        $this->assertDatabaseHas('users', $params);
        $this->assertEquals($params['email'], $user->email);
    }

    public function testUpdatePassword()
    {
        $user = $this->user(['password' => '4_n3w_h0p3']);
        $params = $this->validPasswordParams();

        $this->actingAs($user)
            ->patch('/settings/password', $params)
            ->assertStatus(302)
            ->assertRedirect('/settings/password');

        $user->refresh();
        $this->assertTrue(Hash::check($params['password'], $user->password));
    }

    public function testUpdatePasswordFail()
    {
        $user = $this->user(['password' => '4_n3w_h0p3']);
        $params = $this->validPasswordParams(['current_password' => '7h3_l457_j3d1']);

        $this->actingAs($user)
            ->patch('/settings/password', $params)
            ->assertStatus(302);

        $user->refresh();
        $this->assertFalse(Hash::check($params['password'], $user->password));
    }

    /**
     * Valid params for updating or creating a resource
     *
     * @param  array  $overrides new params
     * @return array  Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'Padmé',
            'email' => 'padme@amidala.na',
        ], $overrides);
    }

    /**
     * Valid params for updating or creating a resource's password
     *
     * @param  array  $overrides new params
     * @return array  Valid params for updating or creating a resource
     */
    private function validPasswordParams($overrides = [])
    {
        return array_merge([
            'current_password' => '4_n3w_h0p3',
            'password' => '7h3_3mp1r3_57r1k35_b4ck',
            'password_confirmation' => '7h3_3mp1r3_57r1k35_b4ck'
        ], $overrides);
    }
}
