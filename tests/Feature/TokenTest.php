<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

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
