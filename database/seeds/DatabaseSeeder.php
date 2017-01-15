<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'darthvader@deathstar.ds')->first();
        if (! $user) {
            $user = User::create([
                'name' => 'anakin',
                'email' => 'darthvader@deathstar.ds',
                'password' => Hash::make('4nak1n')
            ]);
        }
    }
}
