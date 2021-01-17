<?php

namespace App\Providers;

use App\Events\CommentEvent;
use App\Events\MessageEvent;
use App\Events\PostEvent;
use App\Listeners\CommentEventListener;
use App\Listeners\MessageEventListener;
use App\Listeners\PostEventListener;
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
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MessageEvent::class => [
            MessageEventListener::class,
        ],
        PostEvent::class => [
            PostEventListener::class,
        ],
        CommentEvent::class => [
            CommentEventListener::class,
        ]

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
