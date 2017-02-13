<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use App\User;
use App\Role;
use App\Comment;
use Faker\Factory;

class UsersViewsTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testUserShowLink()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit('/')
            ->click(__('users.profil'))
            ->seeRouteIs('users.show', $user);
    }

    public function testUserProfil()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit(route('users.show', $user))
            ->see(__('users.nb_of_comments'))
            ->see(__('users.nb_of_posts'))
            ->see(__('users.edit'))
            ->see(__('roles.none'));
    }

    public function testUserProfilRoles()
    {
        $user = factory(User::class)->create();
        $role_admin = factory(Role::class)->states('admin')->create();
        $role_editor = factory(Role::class)->states('editor')->create();

        $this->actingAs($user)
            ->visit(route('users.show', $user))
            ->see(__('roles.admin'))
            ->see(__('roles.editor'));
    }

    public function testUserEditLink()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit(route('users.show', $user))
            ->click(__('users.edit'))
            ->seeRouteIs('users.edit', $user);
    }

    public function testUserEdit()
    {
        $faker = Factory::create();
        $admin = factory(User::class)->create();
        $admin->roles()->attach(factory(Role::class)->states('admin')->create());

        $this->actingAs($admin)
            ->visit(route('users.edit', $admin))
            ->type($faker->name, 'name')
            ->press(__('forms.actions.save'))
            ->see(__('users.updated'));
    }

    public function testUserEditRoles()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->states('admin')->create();

        $this->actingAs($user)
            ->visit(route('users.edit', $user))
            ->dontSee(__('roles.admin'));
    }
}
