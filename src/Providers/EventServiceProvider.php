<?php

namespace BrankoDragovic\Webhook\Providers;

use BrankoDragovic\Webhook\Event\StatusUpdated;
use BrankoDragovic\Webhook\Listeners\Notify;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        StatusUpdated::class => [
            Notify::class,
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}
