<?php

use App\Role;
use App\Token;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        Role::firstOrCreate(['name' => Role::ROLE_EDITOR]);
        $role_admin = Role::firstOrCreate(['name' => Role::ROLE_ADMIN]);

        // Users
        if (User::where('email', 'darthvader@deathstar.ds')->doesntExist()) {
            $user = User::create([
                'name' => 'anakin',
                'email' => 'darthvader@deathstar.ds',
                'password' => '4nak1n'
            ]);

            $user->roles()->attach($role_admin->id);
        }

        // API tokens
        User::where('api_token', null)->get()->each->update([
            'api_token' => Token::generate()
        ]);
    }
}
