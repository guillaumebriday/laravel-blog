<?php

namespace Tests\Browser;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use Faker\Factory;

class UsersBrowserTest extends BrowserKitTest
{
    use DatabaseMigrations;

    /**
     * it clicks on my profil link in dropdown
     * @return void
     */
    public function testUserShowLink()
    {
        $user = $this->user();

        $this->actingAs($user)
            ->visit('/')
            ->click('Mon profil')
            ->seeRouteIs('users.show', $user);
    }

    /**
     * it clicks on edition link in user profil
     * @return void
     */
    public function testUserEditLink()
    {
        $user = $this->user();

        $this->actingAs($user)
            ->visit("/users/{$user->id}")
            ->click('Éditer')
            ->seeRouteIs('users.edit', $user);
    }

    /**
     * it updates the user through edit form
     * @return void
     */
    public function testUserUpdate()
    {
        $user = $this->user();
        $faker = Factory::create();

        $this->actingAs($user)
            ->visit("/users/{$user->id}/edit")
            ->type($faker->name, 'name')
            ->press('Sauvegarder')
            ->see('Le profil a bien été mis à jour');
    }

    /**
     * it generates a personnal acces token
     * @return void
     */
    public function testUserGenerateApiToken()
    {
        $user = $this->user(['api_token' => null]);

        $this->actingAs($user)
            ->visit("/users/{$user->id}/edit")
            ->see("Aucune clé d'API disponible.")
            ->press('Générer')
            ->see("La clé d'API a bien été générée")
            ->see('Supprimer');
    }

    /**
     * it destroy a personnal acces token
     * @return void
     */
    public function testUserDestroyApiToken()
    {
        $user = $this->user();

        $this->actingAs($user)
            ->visit("/users/{$user->id}/edit")
            ->press('Supprimer')
            ->see("La clé d'API a bien été supprimée")
            ->see("Aucune clé d'API disponible");
    }
}
