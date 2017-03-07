<?php

namespace Tests\Browser\Admin;

use Tests\BrowserKitTest;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use Faker\Factory;

class UsersBrowserTest extends BrowserKitTest
{
    use DatabaseMigrations;

    /**
     * it clicks on user edit link in admin users index
     * @return void
     */
    public function testUserIndexEditLink()
    {
        $admin = $this->admin();
        $anakin = factory(User::class)->states('anakin')->create();

        $this->actingAs($admin)
            ->visit('/admin/users')
            ->click('Anakin')
            ->seeRouteIs('admin.users.edit', $anakin);
    }

    /**
     * it clicks on user profil link in user edit admin view
     * @return void
     */
    public function testUserProfilViewLink()
    {
        $admin = $this->admin();
        $user = $this->user();

        $this->actingAs($admin)
            ->visit("/admin/users/{$user->id}/edit")
            ->click('Voir le profil')
            ->seeRouteIs('users.show', $user);
    }

    /**
     * it updates the user through admin edit form
     * @return void
     */
    public function testUserUpdate()
    {
        $faker = Factory::create();
        $admin = $this->admin();
        $user = $this->user();

        $this->actingAs($admin)
            ->visit("/admin/users/{$user->id}/edit")
            ->type($faker->name, 'name')
            ->type($faker->email, 'email')
            ->check('roles[1]')
            ->press('Mettre à jour')
            ->see('Le profil a bien été mis à jour');
    }
}
