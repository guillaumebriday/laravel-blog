<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminAuthorized()
    {
        $this->actingAs($this->admin())
            ->get('/admin/dashboard')
            ->assertStatus(200);
    }

    public function testAdminForbidden()
    {
        $this->actingAs($this->user())
            ->get('/admin/dashboard')
            ->assertStatus(302)
            ->assertRedirect('/');

        $this->assertEquals(session('errors')->first(), "Cette opération n'est pas autorisée.");
    }
}
