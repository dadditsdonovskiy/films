<?php

namespace App\Http\Controllers\Api\User;

use App\Events\Api\Auth\User\UserPasswordChanged;
use App\Http\Controllers\Controller;
use App\Services\Auth\PasswordUserService;
use App\Http\Requests\Api\User\ChangePassword;

class ChangePasswordController extends Controller
{
    /**
     * @var PasswordUserService
     */
    protected $passwordUserService;

    /**
     * UserController constructor.
     *
     * @param PasswordUserService $passwordUserService
     */
    public function __construct(PasswordUserService $passwordUserService)
    {
        $this->passwordUserService = $passwordUserService;
    }

    public function __invoke(ChangePassword $request)
    {
        $user = auth()->user();
        $this->passwordUserService->changePassword($user, $request->get('password'));

        event(new UserPasswordChanged($user));

        return response()->noContent();
    }
}
