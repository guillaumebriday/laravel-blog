<?php

namespace App\Jobs;

use App\Models\NewsletterSubscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UnsubscribeEmailNewsletter implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $email) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = $this->email;

        $newsletterSubscription = NewsletterSubscription::where('email', $email)->first();
        if ($newsletterSubscription) {
            $newsletterSubscription->delete();
        }
    }
}
