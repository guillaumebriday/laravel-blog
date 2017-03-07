<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Users
        $user = User::where('email', 'darthvader@deathstar.ds')->first();
        if (! $user) {
            $user = User::create([
                'name' => 'anakin',
                'email' => 'darthvader@deathstar.ds',
                'password' => bcrypt('4nak1n')
            ]);
        }

        // Roles
        Role::firstOrCreate(['name' => Role::ROLE_ADMIN]);
        Role::firstOrCreate(['name' => Role::ROLE_EDITOR]);
    }
}
