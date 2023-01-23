<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LoginUser;
use App\Http\Resources\Api\Auth\AccessTokenResource;
use App\Models\Auth\User;
use App\Validators\ErrorList;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

use function auth;
use function request;
use function response;

class AuthController extends Controller
{
    /**
     * @param LoginUser $loginUser
     * @return Response
     */
    public function login(LoginUser $loginUser): Response
    {
        $user = User::where('email', $loginUser->get('email'))->first();
        if (!$user || !Hash::check($loginUser->get('password'), $user->password)) {
            throw new HttpResponseException(
                response(
                    [
                        [
                            'field' => 'password',
                            'message' => __('validation.credentials_invalid'),
                        ],
                    ],
                    422
                )
            );
        }
        $token = $user->createToken($loginUser->get('deviceName', request()->userAgent()));
        return response(new AccessTokenResource($token), 201);
    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        auth()->user()->currentAccessToken()->delete();
        return response("", 204);
    }
}
