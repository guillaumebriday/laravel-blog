<?php

namespace App\Jobs;

use App\Models\NewsletterSubscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Foundation\Queue\Queueable;

class PrepareNewsletterSubscriptionEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $newsletterSubscriptions = NewsletterSubscription::all();

        $newsletterSubscriptions->each(fn ($newsletterSubscription): PendingDispatch => dispatch(new SendNewsletterSubscriptionEmail($newsletterSubscription->email)));

        dispatch(new PrepareNewsletterSubscriptionEmail)->delay(carbon('next month'));
    }
}
