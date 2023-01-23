<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Events\Api\Auth\UserProviderRegistered;
use App\Exceptions\GeneralException;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SocializeAuthService
{
    protected $createUserService;

    public function __construct(CreateUserService $createUserService)
    {
        $this->createUserService = $createUserService;
    }

    /**
     * @param $data
     * @param $provider
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findOrCreateProvider($data, $provider): User
    {
        // User email may not provided.
        $user_email = $data->email ?: "{$data->id}@{$provider}.com";

        $user = User::query()->where('email', '=', $user_email)->first();

        /*
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        DB::beginTransaction();
        if (!$user) {
            // Get users first name and last name from their full name
            $data = [
                'email' => $user_email,
                'password' => Str::random(32)
            ];
            $this->createUserService->create($data);
            event(new UserProviderRegistered($user));
        }

        // See if the user has logged in with this social account before
        if (!$user->hasProvider($provider)) {
            // Gather the provider data for saving and associate it with the user
            $user->providers()->save(
                new SocialAccount(
                    [
                        'provider' => $provider,
                        'provider_id' => $data->id,
                        'token' => $data->token,
                        'email' => $data->email,
                        'avatar' => $data->avatar,
                    ]
                )
            );
        } else {
            // Update the users information, token and avatar can be updated.
            $user->providers()->update(
                [
                    'token' => $data->token,
                    'avatar' => $data->avatar,
                ]
            );
        }
        DB::commit();

        return $user;
    }
}
