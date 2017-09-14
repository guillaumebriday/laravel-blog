<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CheckRoleMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    public function testAdminAuthorized()
    {
        $response = $this->actingAs($this->admin())
                         ->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function testAdminForbidden()
    {
        $response = $this->actingAs($this->user())
                         ->get('/admin/dashboard');

        $response->assertStatus(302)
                 ->assertRedirect('/');

        $this->assertEquals(session('errors')->first(), "Cette opération n'est pas autorisée.");
    }
}
