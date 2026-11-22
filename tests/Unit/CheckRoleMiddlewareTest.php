<?php

test('admin authorized', function () {
    $this->actingAsAdmin()
        ->get('/admin/dashboard')
        ->assertOk();
});

test('admin forbidden', function () {
    $this->actingAsUser()
        ->get('/admin/dashboard')
        ->assertRedirect('/');

    $this->followRedirects($this->get('/admin/dashboard'))
        ->assertSee('Not authorized.');
});
