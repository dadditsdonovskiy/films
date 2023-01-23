<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Auth\AccessTokenResource;
use App\Services\Auth\SocializeAuthService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class SocialLoginController.
 */
class SocialLoginController extends Controller
{
    /**
     * @var SocializeAuthService
     */
    protected $socializeAuthService;

    /**
     * SocialLoginController constructor.
     *
     * @param SocializeAuthService $socializeAuthService
     */
    public function __construct(SocializeAuthService $socializeAuthService)
    {
        $this->socializeAuthService = $socializeAuthService;
    }

    /**
     * @param Request $request
     * @param $provider
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     * @throws GeneralException
     *
     */
    public function login(Request $request, $provider)
    {
        $request->validate(
            [
                'token' => 'required',
            ]
        );
        $userSocial = Socialite::driver($provider)->userFromToken($request->get('token'));
        $user = $this->socializeAuthService->findOrCreateProvider($userSocial, $provider);
        $token = $user->createToken('Laravel Password Grant Client');

        return new AccessTokenResource($token);
    }
}
