<?php

namespace App\Http\Controllers\Backend\User;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;

class DeleteController extends Controller
{
    /**
     * Where to redirect users after delete.
     *
     * @var string
     */
    protected $redirectTo = '/user';

    public function delete(User $user)
    {
        if ($user->id === auth()->id()) {
            auth()->logout();
        }
        if ($user->delete()) {
            session()->flash('success', 'User was deleted');
        } else {
            session()->flash('error', 'User was not deleted');
        }
        return response()->redirectTo($this->redirectTo);
    }
}
