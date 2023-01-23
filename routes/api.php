<?php

use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\StaticPage\StaticPageController;
use App\Http\Controllers\Api\SwaggerController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\ChangePasswordController;
use App\Http\Controllers\Api\User\CurrentController;
use App\Http\Controllers\Api\User\EmailVerificationController;
use App\Http\Controllers\Api\User\RegisterController;
use App\Http\Controllers\Api\User\ResetPasswordController;
use App\Http\Controllers\Api\User\SocialLoginController;
use App\Http\Controllers\Api\User\TokenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    ['middleware' => ['json.formatter']],
    function () {
        Route::group(
            ['prefix' => 'user'],
            function () {
                Route::group(
                    ['middleware' => ['auth:sanctum', 'verified']],
                    function () {
                        Route::get('current', CurrentController::class);
                        Route::post('logout', [AuthController::class, 'logout']);
                        Route::patch('change-password', ChangePasswordController::class);
                        Route::get('token', [TokenController::class, 'index']);
                        Route::delete('token/{id}', [TokenController::class, 'delete']);
                    }
                );
                Route::post('register', RegisterController::class);
                Route::post('login', [AuthController::class, 'login']);
                Route::post('login/{provider}', [SocialLoginController::class, 'login']);
                Route::post('recovery-password', [ResetPasswordController::class, 'recoveryPassword']);
                Route::post('new-password', [ResetPasswordController::class, 'newPassword']);
            }
        );
        Route::group(
            ['prefix' => 'pages'],
            function () {
                Route::get('', [StaticPageController::class, 'index']);
                Route::get('{slug}', [StaticPageController::class, 'view']);
            }
        );
        Route::group(
            ['prefix' => 'email'],
            function () {
                Route::post('resend', [EmailVerificationController::class, 'resend']);
                Route::post('verification', [EmailVerificationController::class, 'verification']);
            }
        );
        Route::get('config', ConfigController::class);
    }
);

Route::get('swagger/json', [SwaggerController::class, 'json']);
