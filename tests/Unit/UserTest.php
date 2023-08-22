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
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $user->roles()->attach($role);

        $this->assertTrue($user->hasRole($role->name));
    }

    public function testUserIsAdmin()
    {
        $admin = User::factory()->create();
        $role_editor = Role::factory()->editor()->create();
        $role_admin = Role::factory()->admin()->create();

        $admin->roles()->sync([$role_admin->id, $role_editor->id]);

        $this->assertTrue($admin->isAdmin());
    }

    public function testUserIsNotAdmin()
    {
        $user = User::factory()->create();
        $user->roles()->attach(
            Role::factory()->editor()->create()
        );

        $this->assertFalse($user->isAdmin());
    }

    public function testGettingOnlyLastWeekUsers()
    {
        $faker = Factory::create();

        // Older Users
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) use ($faker) {
                $user->registered_at = $faker->dateTimeBetween(carbon('3 months ago'), carbon('2 months ago'));
                $user->save();
            });

        // Newer Users
        User::factory()
            ->count(3)
            ->create()
            ->each(function ($user) use ($faker) {
                $user->registered_at = $faker->dateTimeBetween(carbon('1 week ago'), now());
                $user->save();
            });

        $isDuringLastWeek = true;
        foreach (User::lastWeek()->get() as $user) {
            $isDuringLastWeek = $user->registered_at->between(carbon('1 week ago'), now());

            if (!$isDuringLastWeek) {
                break;
            }
        }

        $this->assertTrue($isDuringLastWeek);
    }

    public function testFullnameAttribute()
    {
        $user = User::factory()->create(['name' => 'LEIA']);

        $this->assertEquals('Leia', $user->fullname);
    }

    public function testRegisteredAt()
    {
        $user = User::factory()->create();
        $this->assertEqualsWithDelta($user->registered_at->timestamp, now()->timestamp, 1);
    }

    public function testAuthorsScope()
    {
        $editor = Role::factory()->editor()->create();
        User::factory()->count(10)->create();
        User::factory()
            ->count(3)
            ->create()
            ->each(function ($user) use ($editor) {
                $user->roles()->attach($editor);
            });

        $authors = User::authors()->get();

        $hasOnlyAuthors = true;
        foreach ($authors as $author) {
            if (!$author->canBeAuthor()) {
                $hasOnlyAuthors = false;
                break;
            }
        }

        $this->assertTrue($hasOnlyAuthors);
        $this->assertCount(3, $authors);
    }
}
