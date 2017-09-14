<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Post;
use App\Role;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it renders admin users index view
     * @return void
     */
    public function testIndex()
    {
        $users = factory(User::class, 24)->create();
        $anakin = factory(User::class)->states('anakin')->create();
        $posts = factory(Post::class, 25)->create(['author_id' => $anakin->id]);

        $response = $this->actingAs($this->admin())->get("/admin/users");

        $response->assertStatus(200)
                 ->assertSee('26 utilisateurs')
                 ->assertSee('25')
                 ->assertSee('anakin@skywalker.st')
                 ->assertSee('Anakin')
                 ->assertSee('Nom')
                 ->assertSee('Email')
                 ->assertSee('Enregistré le');
    }

    /**
     * it renders admin users edit view
     * @return void
     */
    public function testEdit()
    {
        $anakin = factory(User::class)->states('anakin')->create();

        $response = $this->actingAs($this->admin())->get("/admin/users/{$anakin->id}/edit");

        $response->assertStatus(200)
                 ->assertSee('Anakin')
                 ->assertSee('Voir le profil')
                 ->assertSee('anakin@skywalker.st')
                 ->assertSee('Confirmation du mot de passe')
                 ->assertSee('R&ocirc;les')
                 ->assertSee('Mettre à jour')
                 ->assertSee('Administrateur');
    }

    /**
     * it updates requested user in admin dashboard
     * @return void
     */
    public function testUpdate()
    {
        $user = factory(User::class)->create();
        $params = $this->validParams();

        $response = $this->actingAs($this->admin())->patch("/admin/users/{$user->id}", $params);

        $user->refresh();

        $response->assertStatus(302);
        $response->assertRedirect("/admin/users/{$user->id}/edit");
        $this->assertDatabaseHas('users', $params);
        $this->assertEquals($params['email'], $user->email);
    }

    /**
     * it updates requested user's roles in admin dashboard
     * @return void
     */
    public function testUpdateRoles()
    {
        $user = factory(User::class)->create();

        $role_editor = factory(Role::class)->states('editor')->create();
        $params = $this->validParams(['roles' => ['editor' => $role_editor->id]]);

        $response = $this->actingAs($this->admin())->patch("/admin/users/{$user->id}", $params);

        $user->refresh();

        $response->assertStatus(302);
        $response->assertRedirect("/admin/users/{$user->id}/edit");
        $this->assertTrue($user->roles->pluck('id')->contains($role_editor->id));
    }

    /**
     * Valid params for updating or creating a resource
     * @param  array  $overrides new params
     * @return array  Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'Anakin',
            'email' => 'anakin@skywalker.st',
        ], $overrides);
    }
}
