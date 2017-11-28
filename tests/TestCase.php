<?php

namespace Tests;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Return an admin user
     * @return User $admin
     */
    protected function admin($overrides = [])
    {
        $admin = $this->user($overrides);
        $admin->roles()->attach(
            factory(Role::class)->states('admin')->create()
        );

        return $admin;
    }

    /**
     * Return an user
     * @return User
     */
    protected function user($overrides = [])
    {
        return factory(User::class)->create($overrides);
    }
}
