<?php

test('admin authorized', function (): void {
    $this->actingAsAdmin()
        ->get('/admin/dashboard')
        ->assertOk();
});

test('admin forbidden', function (): void {
    $this->actingAsUser()
        ->get('/admin/dashboard')
        ->assertRedirect('/');

    $this->followRedirects($this->get('/admin/dashboard'))
        ->assertSee('Not authorized.');
});
