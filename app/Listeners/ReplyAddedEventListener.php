<?php

namespace App\Listeners;

use App\Events\ReplyAddedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReplyAddedEventListener
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
     * @param  \App\Events\ReplyAddedEvent  $event
     * @return void
     */
    public function handle(ReplyAddedEvent $event)
    {
        //
    }
}
