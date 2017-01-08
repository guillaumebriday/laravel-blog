<?php

use App\User;

class UserHelperTest extends TestCase
{
    public function testUserName()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(ucfirst(strtolower($user->name)), user_name($user));
    }
}
