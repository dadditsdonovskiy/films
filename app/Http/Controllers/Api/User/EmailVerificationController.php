<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\EmailVerificationResend;
use App\Http\Requests\Api\User\EmailVerificationVerification;
use App\Models\Auth\User;
use App\Models\Auth\UserToken;
use App\Notifications\Api\Auth\EmailVerification;
use App\Services\Auth\EmailVerificationService;

class EmailVerificationController extends Controller
{
    /**
     * @var EmailVerificationService
     */
    protected $emailVerificationService;

    /**
     * UserController constructor.
     *
     * @param EmailVerificationService $emailVerificationService
     */
    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * @param EmailVerificationResend $request
     * @return \Illuminate\Http\Response
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function resend(EmailVerificationResend $request)
    {
        $user = User::byEmail($request->get('email'))
            ->emailNotVerified()
            ->firstOrFail();

        $userToken = $this->emailVerificationService->generateToken($user);
        $user->notify(new EmailVerification($userToken->token));

        return response()->noContent();
    }

    /**
     * @param EmailVerificationVerification $request
     * @return \Illuminate\Http\Response
     */
    public function verification(EmailVerificationVerification $request)
    {
        $userToken = UserToken::notExpire()
            ->where(['action' => UserToken::ACTION_EMAIL_VERIFICATION])
            ->where(['token' => $request->get('token')])
            ->firstOrFail();

        $this->emailVerificationService->verification($userToken);
        return response()->noContent();
    }
}
