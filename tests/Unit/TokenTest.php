<?php

namespace Tests\Unit;

use App\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    public function testGenerate()
    {
        $user = factory(User::class)->create();

        $this->assertNotEquals($user->api_token, Token::generate());
    }
}
