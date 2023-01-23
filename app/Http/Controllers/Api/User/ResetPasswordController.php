<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\NewPassword;
use App\Models\Auth\User;
use App\Http\Requests\Api\User\RecoveryPassword;
use App\Notifications\Api\Auth\RecoveryPassword as RecoveryPasswordNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function recoveryPassword(RecoveryPassword $recoveryPassword)
    {

        $user = User::query()->where('email', '=', $recoveryPassword->get('email'))->firstOrFail();
        /**
         * @var $user User
         */
        $token = $this->broker()->createToken($user);
        $user->notify(new RecoveryPasswordNotification($token));

        return response("", 204);
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * Set the user's password.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string $password
     * @return void
     */
    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
    }

    public function newPassword(NewPassword $newPasswordRequest)
    {
        $credentials = [];
        $credentials['email'] = $newPasswordRequest->get('email');
        $credentials['password_confirmation'] = $newPasswordRequest->get('confirmPassword');
        $credentials['token'] = $newPasswordRequest->get('resetToken');
        $credentials['password'] = $newPasswordRequest->get('password');
        $response = $this->broker()->reset(
            $credentials,
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        if ($response == Password::PASSWORD_RESET) {
            return response("", 204);
        } else {
            return response("", 422);
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
