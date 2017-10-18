<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendComment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentPosted  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        //
    }
}
