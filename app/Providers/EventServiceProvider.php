<?php

namespace App\Providers;

use App\Events\ActivityLogEvent;
use App\Events\ViewCountEvent;
use App\Listeners\ActivityLogListener;
use App\Listeners\ViewCountListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ActivityLogEvent::class => [
            ActivityLogListener::class,
        ],
        ViewCountEvent::class => [
            ViewCountListener::class,
        ],
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
