<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class UserHelperTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testUserName()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(ucfirst(strtolower($user->name)), user_name($user));
    }
}
