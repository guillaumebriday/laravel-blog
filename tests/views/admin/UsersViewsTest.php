<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Role;
use Faker\Factory;

class AdminUsersViewsTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testUserIndexEditLink()
    {
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $user = factory(User::class)->create();

        $this->actingAs($admin)
            ->visit(route('admin.users.index'))
            ->click(user_name($user))
            ->seeRouteIs('admin.users.edit', $user);
    }

    public function testUserEdit()
    {
        $faker = Factory::create();
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $user = factory(User::class)->create();

        $this->actingAs($admin)
            ->visit(route('admin.users.edit', $user))
            ->see(user_name($user))
            ->see(__('forms.actions.update'))
            ->see(__('roles.admin'))
            ->see($user->email);
    }

    public function testUserProfilViewLink()
    {
        $faker = Factory::create();
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $user = factory(User::class)->create();

        $this->actingAs($admin)
            ->visit(route('admin.users.edit', $user))
            ->click(__('users.show'))
            ->seeRouteIs('users.show', $user);
    }

    public function testUserUpdate()
    {
        $faker = Factory::create();
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());
        $user = factory(User::class)->create();

        $this->actingAs($admin)
            ->visit(route('admin.users.edit', $user))
            ->type($faker->name, 'name')
            ->type($faker->email, 'email')
            ->check('roles[1]')
            ->press(__('forms.actions.update'))
            ->see(__('users.updated'));
    }
}
