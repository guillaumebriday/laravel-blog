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

        $this->actingAs($user)
            ->patch('/settings/token', [])
            ->assertRedirect('/settings/token');

        $user->refresh();
        $this->assertNotNull($user->api_token);
    }
}
