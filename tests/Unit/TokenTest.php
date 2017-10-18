<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Token;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    public function testGenerate()
    {
        $user = factory(User::class)->create();

        $this->assertNotEquals($user->api_token, Token::generate());
    }
}
