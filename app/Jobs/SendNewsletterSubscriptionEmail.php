<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Post;
use Mail;

class SendNewsletterSubscriptionEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, DispatchesJobs;

    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $posts = Post::lastMonth()->get();
        $email = $this->email;

        Mail::send('emails.newsletter', ['posts' => $posts], function ($message) use ($email) {
            $message->from('hello@app.com', config('app.name', 'Laravel'));

            $message->to($email)->subject(trans('newsletter.email.subject'));
        });
    }
}
