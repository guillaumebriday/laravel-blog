<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminAuthorized()
    {
        $this->actingAsAdmin()
            ->get('/admin/dashboard')
            ->assertOk();
    }

    public function testAdminForbidden()
    {
        $this->actingAsUser()
            ->get('/admin/dashboard')
            ->assertRedirect('/');

        $this->assertEquals(session('errors')->first(), 'Not authorized.');
    }
}
