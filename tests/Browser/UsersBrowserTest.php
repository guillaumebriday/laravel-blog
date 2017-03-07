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
}
