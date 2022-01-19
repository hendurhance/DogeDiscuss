<?php

namespace App\Listeners;

use App\Events\DeleteReplyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteReplyEventListener
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
     * @param  \App\Events\DeleteReplyEvent  $event
     * @return void
     */
    public function handle(DeleteReplyEvent $event)
    {
        //
    }
}
