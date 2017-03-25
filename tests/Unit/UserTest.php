<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Role;
use Faker\Factory;
use Carbon\Carbon;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it checks if user has a specific role
     * @return void
     */
    public function testUserHasRole()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user->roles()->attach($role);

        $this->assertTrue($user->hasRole($role->name));
    }

    /**
     * it checks if user is admin
     * @return void
     */
    public function testUserIsAdmin()
    {
        $admin = factory(User::class)->create();
        $role_editor = factory(Role::class)->states('editor')->create();
        $role_admin = factory(Role::class)->states('admin')->create();

        $admin->roles()->sync([$role_admin->id, $role_editor->id]);

        $this->assertTrue($admin->isAdmin());
    }

    /**
     * it checks if user is not admin
     * @return void
     */
    public function testUserIsNotAdmin()
    {
        $user = factory(User::class)->create();
        $role_editor = factory(Role::class)->states('editor')->create();
        $user->roles()->attach($role_editor);

        $this->assertFalse($user->isAdmin());
    }

    /**
     * it retrieves only users registered last week
     * @return void
     */
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

            if (! $isDuringLastWeek) {
                break;
            }
        }

        $this->assertTrue($isDuringLastWeek);
    }

    /**
     * it tests the fullname attribute
     * @return void
     */
    public function testFullnameAttribute()
    {
        $user = factory(User::class)->create(['name' => 'LEIA']);

        $this->assertEquals('Leia', $user->fullname);
    }

    /**
     * it fills the registered_at field when a user is created
     * @return void
     */
    public function testRegisteredAt()
    {
        $user = factory(User::class)->create();
        $this->assertEquals($user->registered_at->toDateTimeString(), Carbon::now()->toDateTimeString());
    }
}
