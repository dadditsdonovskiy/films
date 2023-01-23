<?php

namespace App\Http\Controllers\Backend\User;

use App\Events\Backend\Auth\User\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\StoreUserRequest;
use App\Services\Auth\CreateUserService;

class CreateController extends Controller
{
    /**
     * Where to redirect users after delete.
     *
     * @var string
     */
    protected $redirectTo = '/user';
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

    /**
     * @return mixed
     */
    public function showForm()
    {
        return view('user.create');
    }

    /**
     * @param StoreUserRequest $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->createUserService->create($request->only(['email', 'password']));

        event(new UserCreated($user));

        return redirect()->route('Backend.auth.user.index')->withSuccess(__('alerts.Backend.users.created'));
    }
}
