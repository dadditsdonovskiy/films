<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\Auth\User;
use Illuminate\Support\Facades\Hash;

class PasswordUserService
{
    public function changePassword(User $user, string $password)
    {
        $user->password = Hash::make($password);
        $user->save();
    }
}
