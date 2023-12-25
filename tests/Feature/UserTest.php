<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testProfil()
    {
        $user = $this->user();
        $comment = Comment::factory()->create(['author_id' => $user->id]);
        $posts = Post::factory()->count(3)->create(['author_id' => $user->id]);

        $this->actingAs($user)
            ->get("/users/{$user->id}")
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee('Comments')
            ->assertSee('Posts')
            ->assertSee('3')
            ->assertSee('Like')
            ->assertSee('Latest comments')
            ->assertSee($comment->content)
            ->assertSee('Latest posts')
            ->assertSee($posts->first()->title)
            ->assertSee('Edit profile');
    }

    public function testEditing()
    {
        $user = $this->user();

        $this->actingAs($user)
            ->get('/settings/account')
            ->assertOk()
            ->assertSee('My profile')
            ->assertSee('My public profile')
            ->assertSee($user->name)
            ->assertSee($user->email)
            ->assertSee('Security')
            ->assertSee('Save');
    }

    public function testUpdate()
    {
        $user = $this->user();
        $params = $this->validParams();

        $this->actingAs($user)
            ->patch('/settings/account', $params)
            ->assertRedirect('/settings/account');

        $this->assertDatabaseHas('users', $params);
        $this->assertEquals($params['email'], $user->refresh()->email);
    }

    public function testUpdatePassword()
    {
        $user = $this->user(['password' => Hash::make('4_n3w_h0p3')]);
        $params = $this->validPasswordParams();

        $this->actingAs($user)
            ->patch('/settings/password', $params)
            ->assertStatus(302)
            ->assertRedirect('/settings/password');

        $this->assertTrue(Hash::check($params['password'], $user->refresh()->password));
    }

    public function testUpdatePasswordFail()
    {
        $user = $this->user(['password' => Hash::make('4_n3w_h0p3')]);
        $params = $this->validPasswordParams(['current_password' => '7h3_l457_j3d1']);

        $this->actingAs($user)
            ->patch('/settings/password', $params)
            ->assertStatus(302);

        $this->assertFalse(Hash::check($params['password'], $user->refresh()->password));
    }

    /**
     * Valid params for updating or creating a resource
     */
    private function validParams(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Padmé',
            'email' => 'padme@amidala.na',
        ], $overrides);
    }

    /**
     * Valid params for updating or creating a resource's password
     */
    private function validPasswordParams(array $overrides = []): array
    {
        return array_merge([
            'current_password' => '4_n3w_h0p3',
            'password' => '7h3_3mp1r3_57r1k35_b4ck',
            'password_confirmation' => '7h3_3mp1r3_57r1k35_b4ck'
        ], $overrides);
    }
}
