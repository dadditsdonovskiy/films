<?php

namespace App\Providers;

use App\Listeners\Api\Auth\SendEmailVerification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\Api\Auth\User\UserCreated::class => [
            \App\Listeners\Api\Auth\SendEmailVerification::class,
        ],
    ];
    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
    ];
}
