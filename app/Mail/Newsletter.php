<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Newsletter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected $posts,
        protected string $email
    ) {
        $this->posts = $posts;
        $this->email = $email;
    }

    /**
     * Build the message.
     */
    public function build(): Newsletter
    {
        return $this->from('hello@app.com', config('app.name', 'Laravel'))
            ->subject(__('newsletter.email.subject'))
            ->view('emails.newsletter')
            ->with([
                'posts' => $this->posts,
                'email' => $this->email
            ]);
    }
}
