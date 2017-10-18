<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Comment;
use App\Post;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testProfil()
    {
        $user = $this->user();
        $role_admin = factory(Role::class)->states('admin')->create();
        $role_editor = factory(Role::class)->states('editor')->create();
        $comment = factory(Comment::class)->create(['author_id' => $user->id]);
        $post = factory(Post::class)->create(['author_id' => $user->id]);

        $this->actingAs($user)
            ->get("/users/{$user->id}")
            ->assertStatus(200)
            ->assertSee(e($user->name))
            ->assertSee(e($user->email))
            ->assertSee('Nombre de commentaires')
            ->assertSee('Administrateur')
            ->assertSee('Éditeur')
            ->assertSee('&Eacute;diter le profil');
    }

    public function testShowWithoutRoles()
    {
        $user = $this->user();

        $this->get("/users/{$user->id}")
            ->assertStatus(200)
            ->assertSee(e($user->name))
            ->assertSee(e($user->email))
            ->assertSee('Nombre de commentaires')
            ->assertSee('Aucun');
    }

    public function testEditing()
    {
        $user = $this->user();

        $response = $this->actingAs($user)->get("/users/{$user->id}/edit");

        $response->assertStatus(200)
                 ->assertSee($user->name)
                 ->assertSee($user->email)
                 ->assertSee('Mot de passe')
                 ->assertSee('Confirmation du mot de passe')
                 ->assertSee('Sauvegarder')
                 ->assertSee('Retour');
    }

    public function testEditingFail()
    {
        $user = $this->user();
        $anakin = factory(User::class)->states('anakin')->create();

        $response = $this->actingAs($user)->get("/users/{$anakin->id}/edit");

        $response->assertStatus(403);
    }

    public function testUpdate()
    {
        $user = $this->user();
        $params = $this->validParams();

        $response = $this->actingAs($user)->patch("/users/{$user->id}", $params);

        $user->refresh();

        $response->assertStatus(302);
        $response->assertRedirect("/users/{$user->id}");
        $this->assertDatabaseHas('users', $params);
        $this->assertEquals($params['email'], $user->email);
    }

    public function testUpdatePassword()
    {
        $user = $this->user();
        $params = $this->validParams([
            'password' => '7h3_3mp1r3_57r1k35_b4ck',
            'password_confirmation' => '7h3_3mp1r3_57r1k35_b4ck'
        ]);

        $response = $this->actingAs($user)->patch("/users/{$user->id}", $params);

        $user->refresh();

        $response->assertStatus(302);
        $response->assertRedirect("/users/{$user->id}");
        $this->assertDatabaseHas('users', array_only($params, ['name', 'email']));
        $this->assertEquals($params['email'], $user->email);
        $this->assertTrue(Hash::check($params['password'], $user->password));
    }

    public function testUpdateOtherUser()
    {
        $user = $this->user();
        $anakin = factory(User::class)->states('anakin')->create();
        $params = $this->validParams();

        $response = $this->actingAs($user)->patch("/users/{$anakin->id}", $params);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', $params);
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
}
