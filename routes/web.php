<?php

use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\User\CreateController as UserCreateController;
use App\Http\Controllers\Backend\User\DeleteController as UserDeleteController;
use App\Http\Controllers\Backend\User\ListController as UserListController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [LoginController::class, 'showLoginForm'])->name('loginForm');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('/', [UserListController::class, 'index']);
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::group(
            ['prefix' => 'user'],
            function () {
                Route::get('/', [UserListController::class, 'index']);
                Route::get('/create', [UserCreateController::class, 'showForm']);
                Route::post('/create', [UserCreateController::class, 'store']);
                Route::delete('/{user}', [UserDeleteController::class, 'delete']);
            }
        );
    }
);


