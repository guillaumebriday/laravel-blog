<?php

use App\Models\Comment;
use App\Models\MediaLibrary;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        Role::firstOrCreate(['name' => Role::ROLE_EDITOR]);
        $role_admin = Role::firstOrCreate(['name' => Role::ROLE_ADMIN]);

        // MediaLibrary
        MediaLibrary::firstOrCreate([]);

        // Users
        $user = User::firstOrCreate(
            ['email' => 'darthvader@deathstar.ds'],
            [
                'name' => 'anakin',
                'password' => Hash::make('4nak1n'),
                'email_verified_at' => now()
            ]
        );

        $user->roles()->sync([$role_admin->id]);

        // Posts
        $post = Post::firstOrCreate(
            [
                'title' => 'Hello World',
                'author_id' => $user->id
            ],
            [
                'posted_at' => now(),
                'content' => "
                    Welcome to Laravel-blog !<br><br>
                    Don't forget to read the README before starting.<br><br>
                    Feel free to add a star on Laravel-blog on Github !<br><br>
                    You can open an issue or (better) a PR if something went wrong."
            ]
        );

        // Comments
        Comment::firstOrCreate(
            [
                'author_id' => $user->id,
                'post_id' => $post->id
            ],
            [
                'posted_at' => now(),
                'content' => "Hey ! I'm a comment as example."
            ]
        );
    }
}
