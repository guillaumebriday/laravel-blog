<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\NewsletterSubscription;
use App\Jobs\SendNewsletterSubscriptionEmail;
use Carbon\Carbon;

class PrepareNewsletterSubscriptionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $newsletterSubscriptions = NewsletterSubscription::all();

        $newsletterSubscriptions->each(function ($newsletterSubscription) {
            SendNewsletterSubscriptionEmail::dispatch($newsletterSubscription->email);
        });

        PrepareNewsletterSubscriptionEmail::dispatch()->delay(Carbon::now()->addSecond());
    }
}
