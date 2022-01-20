<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    /**
     * Create like event listeners for the application.
     * @return void
     */
    protected $listen = [
        'App\Events\LikeEvent' => [
            'App\Listeners\LikeEventListener',
        ],
        'App\Events\DeleteReplyEvent' => [
            'App\Listeners\DeleteReplyEventListener',
        ],
        'App\Events\VoteEvent' => [
            'App\Listeners\VoteEventListener',
        ],
        'App\Events\ReplyAddedEvent' => [
            'App\Listeners\ReplyAddedEventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
