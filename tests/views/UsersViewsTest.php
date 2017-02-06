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
            ->click(trans('users.profil'))
            ->seeRouteIs('users.show', $user);
    }

    public function testUserProfil()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit(route('users.show', $user))
            ->see(trans('users.nb_of_comments'))
            ->see(trans('users.nb_of_posts'))
            ->see(trans('users.edit'))
            ->see(trans('roles.none'));
    }

    public function testUserProfilRoles()
    {
        $user = factory(User::class)->create();
        $role_admin = factory(Role::class)->states('admin')->create();
        $role_editor = factory(Role::class)->create(['name' => 'editor']);

        $this->actingAs($user)
            ->visit(route('users.show', $user))
            ->see(trans('roles.admin'))
            ->see(trans('roles.editor'));
    }

    public function testUserEditLink()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit(route('users.show', $user))
            ->click(trans('users.edit'))
            ->seeRouteIs('users.edit', $user);
    }

    public function testUserEdit()
    {
        $user = factory(User::class)->create();
        $faker = Factory::create();
        $role = factory(Role::class)->create(['name' => 'admin']);

        $user->roles()->sync([$role->id]);

        $this->actingAs($user)
            ->visit(route('users.edit', $user))
            ->type($faker->name, 'name')
            ->check('roles[1]')
            ->press(trans('forms.actions.save'))
            ->see(trans('users.updated'));
    }

    public function testUserEditRoles()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'admin']);

        $this->actingAs($user)
            ->visit(route('users.edit', $user))
            ->dontSee(trans('roles.admin'));
    }
}
