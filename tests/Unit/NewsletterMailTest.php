<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use App\Mail\Newsletter;
use App\Post;
use App\User;

class NewsletterMailTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * it checks if the newsletter is sent
     * @return void
     */
    public function testNewsletterMail()
    {
        $user = $this->user();
        $posts = factory(Post::class, 10)->create();

        Mail::fake();

        Mail::to($user->email)->send(new Newsletter($posts, $user->email));

        Mail::assertSent(Newsletter::class, function ($mailable) use ($user) {
            return $mailable->hasTo($user->email);
        });
    }
}
