<?php

namespace Tests\Unit;

use App\Mail\Newsletter;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NewsletterMailTest extends TestCase
{
    use RefreshDatabase;

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
