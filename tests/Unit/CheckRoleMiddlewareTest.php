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
            ->assertStatus(200);
    }

    public function testAdminForbidden()
    {
        $this->actingAsUser()
            ->get('/admin/dashboard')
            ->assertRedirect('/');

        $this->assertEquals(session('errors')->first(), "Cette opération n'est pas autorisée.");
    }
}
