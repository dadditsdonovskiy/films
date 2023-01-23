<?php

namespace App\Http\Controllers\Api\User;

use App\Events\Api\Auth\User\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\RegisterUser;
use App\Http\Resources\Api\Auth\AccessTokenResource;
use App\Services\Auth\CreateUserService;

class RegisterController extends Controller
{
    /**
     * @var CreateUserService
     */
    protected $createUserService;

    /**
     * UserController constructor.
     *
     * @param CreateUserService $createUserService
     */

    public function __construct(CreateUserService $createUserService)
    {
        $this->createUserService = $createUserService;
    }

    public function __invoke(RegisterUser $registerUser)
    {
        $user = $this->createUserService->create($registerUser->only(['email', 'password']));
        $token = $user->createToken($registerUser->get('deviceName', request()->userAgent()));

        event(new UserCreated($user));

        return new AccessTokenResource($token);
    }
}
