<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\User;
use App\Comment;
use App\NewsletterSubscription;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        factory(User::class, 10)
            ->create()
            ->each(function ($user) use ($faker) {
                factory(Post::class, $faker->numberBetween(2, 20))
                    ->create([
                        'author_id' => $user->id
                    ])
                    ->each(function ($post) use ($faker) {
                        factory(Comment::class, $faker->numberBetween(10, 60))
                            ->create([
                                'post_id' => $post->id
                            ]);
                    });
            });

        factory(NewsletterSubscription::class, $faker->numberBetween(10, 50))->create();
    }
}
