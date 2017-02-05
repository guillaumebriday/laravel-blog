<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $user->roles()->sync([$role->id]);

        $this->assertTrue($user->hasRole($role->name));
    }

    public function testIsAdmin()
    {
        $user = factory(User::class)->create();
        $role_editor = factory(Role::class)->create(['name' => 'editor']);
        $role_admin = factory(Role::class)->create(['name' => 'admin']);

        $user->roles()->sync([$role_editor->id, $role_admin->id]);

        $this->assertTrue($user->isAdmin());
    }

    public function testIsAdminFail()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'editor']);
        $user->roles()->sync([$role->id]);

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
