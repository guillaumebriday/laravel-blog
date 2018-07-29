<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserHasRole()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user->roles()->attach($role);

        $this->assertTrue($user->hasRole($role->name));
    }

    public function testUserIsAdmin()
    {
        $admin = factory(User::class)->create();
        $role_editor = factory(Role::class)->states('editor')->create();
        $role_admin = factory(Role::class)->states('admin')->create();

        $admin->roles()->sync([$role_admin->id, $role_editor->id]);

        $this->assertTrue($admin->isAdmin());
    }

    public function testUserIsNotAdmin()
    {
        $user = factory(User::class)->create();
        $user->roles()->attach(
            factory(Role::class)->states('editor')->create()
        );

        $this->assertFalse($user->isAdmin());
    }

    public function testGettingOnlyLastWeekUsers()
    {
        $faker = Factory::create();

        // Older Users
        factory(User::class, 10)
                ->create()
                ->each(function ($user) use ($faker) {
                    $user->registered_at = $faker->dateTimeBetween(carbon('3 months ago'), carbon('2 months ago'));
                    $user->save();
                });

        // Newer Users
        factory(User::class, 3)
                ->create()
                ->each(function ($user) use ($faker) {
                    $user->registered_at = $faker->dateTimeBetween(carbon('1 week ago'), now());
                    $user->save();
                });

        $isDuringLastWeek = true;
        foreach (User::lastWeek()->get() as $user) {
            $isDuringLastWeek = $user->registered_at->between(carbon('1 week ago'), now());

            if (! $isDuringLastWeek) {
                break;
            }
        }

        $this->assertTrue($isDuringLastWeek);
    }

    public function testFullnameAttribute()
    {
        $user = factory(User::class)->create(['name' => 'LEIA']);

        $this->assertEquals('Leia', $user->fullname);
    }

    public function testRegisteredAt()
    {
        $user = factory(User::class)->create();
        $this->assertEquals($user->registered_at->toDateTimeString(), now()->toDateTimeString());
    }

    public function testAuthorsScope()
    {
        $editor = factory(Role::class)->states('editor')->create();
        factory(User::class, 10)->create();
        factory(User::class, 3)
            ->create()
            ->each(function ($user) use ($editor) {
                $user->roles()->attach($editor);
            });

        $authors = User::authors()->get();

        $hasOnlyAuthors = true;
        foreach ($authors as $author) {
            if (! $author->canBeAuthor()) {
                $hasOnlyAuthors = false;
                break;
            }
        }

        $this->assertTrue($hasOnlyAuthors);
        $this->assertCount(3, $authors);
    }
}
