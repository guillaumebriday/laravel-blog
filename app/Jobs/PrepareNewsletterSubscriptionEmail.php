<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\NewsletterSubscription;
use App\Jobs\SendNewsletterSubscriptionEmail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Carbon\Carbon;

class PrepareNewsletterSubscriptionEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, DispatchesJobs;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $newsletterSubscriptions = NewsletterSubscription::all();

        $newsletterSubscriptions->each(function ($newsletterSubscription) {
            $this->dispatch(new SendNewsletterSubscriptionEmail($newsletterSubscription->email));
        });

        $this->dispatch((new PrepareNewsletterSubscriptionEmail())->delay(Carbon::now()->addMonth()));
    }
}
