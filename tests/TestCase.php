<?php

namespace Tests;

use App\Models\MediaLibrary;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        MediaLibrary::firstOrCreate([]);
    }

    /**
     * Return an admin user
     */
    protected function admin(array $overrides = []): User
    {
        $admin = $this->user($overrides);
        $admin->roles()->attach(
            Role::factory()->admin()->create()
        );

        return $admin;
    }

    /**
     * Return an user
     */
    protected function user(array $overrides = []): User
    {
        return User::factory()->create($overrides);
    }

    /**
     * Acting as an admin
     */
    protected function actingAsAdmin($api = null)
    {
        $this->actingAs($this->admin(), $api);

        return $this;
    }

    /**
     * Acting as an user
     */
    protected function actingAsUser($api = null)
    {
        $this->actingAs($this->user(), $api);

        return $this;
    }
}
