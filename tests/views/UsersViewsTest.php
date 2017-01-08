<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Post;
use App\User;
use App\Comment;
use Faker\Factory;

class UsersViewsTest extends TestCase
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
            ->see(trans('users.edit'));
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

        $this->actingAs($user)
            ->visit(route('users.edit', $user))
            ->type($faker->name, 'name')
            ->press(trans('forms.actions.save'))
            ->see(trans('users.updated'));
    }
}
