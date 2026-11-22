<?php

use App\Mail\Newsletter;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;

test('newsletter mail', function (): void {
    $user = $this->user();
    $posts = Post::factory()->count(2)->create();

    Mail::fake();

    Mail::to($user->email)->send(new Newsletter($posts, $user->email));

    Mail::assertSent(Newsletter::class, fn ($mailable) => $mailable->hasTo($user->email));
});
