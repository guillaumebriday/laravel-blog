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
        factory(Post::class, 20)
            ->create()
            ->each(function ($post) {
                factory(Comment::class, 5)
                    ->create([
                        'post_id' => $post->id
                    ]);
            });

        factory(NewsletterSubscription::class, 5)->create();
    }
}
