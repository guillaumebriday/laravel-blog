<?php

use App\Models\Comment;
use App\Models\NewsletterSubscription;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DevDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()
            ->count(20)
            ->create()
            ->each(function ($post) {
                Comment::factory()
                    ->count(5)
                    ->create([
                        'post_id' => $post->id
                    ]);
            });

        NewsletterSubscription::factory()->count(5)->create();
    }
}
