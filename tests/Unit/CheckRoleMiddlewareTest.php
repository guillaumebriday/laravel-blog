<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CheckRoleMiddlewareTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it checks if the format returned is the default one
     * @return void
     */
    public function testAdminAuthorized()
    {
        $response = $this->actingAs($this->admin())
                         ->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    /**
     * it checks if the format returned is the default one
     * @return void
     */
    public function testAdminForbidden()
    {
        $response = $this->actingAs($this->user())
                         ->get('/admin/dashboard');

        $response->assertStatus(302)
                 ->assertRedirect('/');

        $this->assertEquals(session('errors')->first(), "Cette opération n'est pas autorisée.");
    }
}
