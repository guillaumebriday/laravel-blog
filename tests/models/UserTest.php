<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Role;
use Faker\Factory;
use Carbon\Carbon;

class UserTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testHasRole()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user->roles()->attach($role);

        $this->assertTrue($user->hasRole($role->name));
    }

    public function testIsAdmin()
    {
        $admin = factory(User::class)->create();
        $role_editor = factory(Role::class)->states('editor')->create();
        $role_admin = factory(Role::class)->states('admin')->create();
        $admin->roles()->sync([$role_admin->id, $role_editor->id]);

        $this->assertTrue($admin->isAdmin());
    }

    public function testIsAdminFail()
    {
        $user = factory(User::class)->create();
        $role_editor = factory(Role::class)->states('editor')->create();
        $user->roles()->attach($role_editor);

        $this->assertFalse($user->isAdmin());
    }

    public function testGettingOnlyLastWeekUsers()
    {
        $faker = Factory::create();

        // Older Users
        factory(User::class, 10)
                ->create()
                ->each(function ($user) use ($faker) {
                    $user->registered_at = $faker->dateTimeBetween(Carbon::now()->subMonths(3), Carbon::now()->subMonths(2));
                    $user->save();
                });

        // Newer Users
        factory(User::class, 3)
                ->create()
                ->each(function ($user) use ($faker) {
                    $user->registered_at = $faker->dateTimeBetween(Carbon::now()->subWeek(), Carbon::now());
                    $user->save();
                });

        $isDuringLastWeek = true;
        foreach (User::lastWeek()->get() as $user) {
            $isDuringLastWeek = $user->registered_at->between(Carbon::now()->subWeek(), Carbon::now());
        }

        $this->assertTrue($isDuringLastWeek);
    }
}
