<?php

namespace App\Listeners\Api\Auth;

use App\Events\Api\Auth\User\UserCreated;
use App\Notifications\Api\Auth\EmailVerification;
use App\Services\Auth\EmailVerificationService;

/**
 * Class UserEventListener.
 */
class SendEmailVerification
{
    /**
     * @param $event
     */
    public function handle(UserCreated $event)
    {
        $emailVerificationService = new EmailVerificationService();
        $userToken = $emailVerificationService->generateToken($event->user);
        $event->user->notify(new EmailVerification($userToken->token));
    }
}
