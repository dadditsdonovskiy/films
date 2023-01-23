<?php

namespace App\Listeners\Backend\Auth;

use App\Events\Backend\Auth\User\UserCreated;
use App\Events\Backend\Auth\User\UserDeleted;
use App\Events\Backend\Auth\User\UserPasswordChanged;

/**
 * Class UserEventListener.
 */
class UserEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event) //NOSONAR
    {
        logger('User Created');
    }

    /**
     * @param $event
     */
    public function onUpdated($event) //NOSONAR
    {
        logger('User Updated');
    }

    /**
     * @param $event
     */
    public function onDeleted($event) //NOSONAR
    {
        logger('User Deleted');
    }

    /**
     * @param $event
     */
    public function onPasswordChanged($event) //NOSONAR
    {
        logger('User Password Changed');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            UserCreated::class,
            'App\Listeners\Backend\Auth\UserEventListener@onCreated'
        );

        $events->listen(
            UserDeleted::class,
            'App\Listeners\Backend\Auth\UserEventListener@onDeleted'
        );

        $events->listen(
            UserPasswordChanged::class,
            'App\Listeners\Backend\Auth\UserEventListener@onPasswordChanged'
        );
    }
}
