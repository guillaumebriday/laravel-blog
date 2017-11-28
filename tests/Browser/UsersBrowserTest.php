<?php

namespace Tests\Browser;

use Faker\Factory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest;

class UsersBrowserTest extends BrowserKitTest
{
    use RefreshDatabase;

    public function testUserShowLink()
    {
        $user = $this->user();

        $this->actingAs($user)
            ->visit('/')
            ->click('Mon profil public')
            ->seeRouteIs('users.show', $user);
    }

    public function testUserEditLink()
    {
        $user = $this->user();

        $this->actingAs($user)
            ->visit("/users/{$user->id}")
            ->click('Éditer')
            ->seeRouteIs('users.edit');
    }

    public function testUserUpdate()
    {
        $faker = Factory::create();

        $this->actingAsUser()
            ->visit('/settings/account')
            ->type($faker->name, 'name')
            ->press('Sauvegarder')
            ->see('Le profil a bien été mis à jour');
    }

    public function testPasswordUpdate()
    {
        $faker = Factory::create();
        $current_password = '4_n3w_h0p3';
        $user = $this->user(['password' => $current_password]);
        $password = $faker->password;

        $this->actingAs($user)
            ->visit('/settings/password')
            ->type($current_password, 'current_password')
            ->type($password, 'password')
            ->type($password, 'password_confirmation')
            ->press('Sauvegarder')
            ->see('Le mot de passe a bien été mis à jour');
    }

    public function testPasswordUpdateFail()
    {
        $faker = Factory::create();
        $user = $this->user();
        $password = $faker->password;

        $this->actingAs($user)
            ->visit('/settings/password')
            ->type('4_n3w_h0p3', 'current_password')
            ->type($password, 'password')
            ->type($password, 'password_confirmation')
            ->press('Sauvegarder')
            ->see("Le mot de passe actuel n'est pas valide.");
    }

    public function testUserGenerateApiToken()
    {
        $user = $this->user(['api_token' => null]);

        $this->actingAs($user)
            ->visit('/settings/token')
            ->press('Générer')
            ->see("La clé d'API a bien été générée");
    }
}
