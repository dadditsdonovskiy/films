<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\GeneralException;
use App\Models\Auth\User;
use App\Models\Auth\UserToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmailVerificationService
{
    /**
     * @param User $user
     * @return UserToken
     * @throws GeneralException
     * @throws \Throwable
     */
    public function generateToken(User $user): UserToken
    {
        DB::beginTransaction();
        $user->email_verified_at = null;
        $user->saveOrFail();

        // Delete old user tokens

        UserToken::query()
            ->where(['user_id' => $user->id])
            ->where(['action' => UserToken::ACTION_EMAIL_VERIFICATION])
            ->delete();

        $userToken = UserToken::query()->create(
            [
                'expires_at' => time() + config('api.expires_time_link'),
                'user_id' => $user->id,
                'action' => UserToken::ACTION_EMAIL_VERIFICATION,
                'token' => Str::random(32),
            ]
        );
        if ($userToken) {
            DB::commit();

            return $userToken;
        }
        DB::rollBack();
        throw new GeneralException(__('exceptions.common.not_created', ['name' => 'Token']));
    }

    public function verification(UserToken $userToken): void
    {
        DB::beginTransaction();

        $user = $userToken->user;
        $user->markEmailAsVerified();
        $userToken->delete();

        DB::commit();
    }
}
