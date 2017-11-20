<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $user = $this->user(['api_token' => null]);

        $response = $this->actingAs($user)->post("/tokens/{$user->id}", []);

        $user->refresh();

        $response->assertStatus(302);
        $response->assertRedirect("/users/{$user->id}/edit");
        $this->assertNotNull($user->api_token);
    }
}
