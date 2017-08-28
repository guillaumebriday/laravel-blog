<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Token;

class TokenTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it returns a unique personnal access token
     *
     * @return void
     */
    public function testGenerate()
    {
        $user = factory(User::class)->create();

        $this->assertNotEquals($user->api_token, Token::generate());
    }
}
