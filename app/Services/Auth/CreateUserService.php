<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Exceptions\GeneralException;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class RegisterUserService
 * @package App\Services\Auth
 */
class CreateUserService
{
    /**
     * @param $data
     * @return User
     * @throws GeneralException
     */
    public function create($data): User
    {
        DB::beginTransaction();
        $user = User::query()->create(
            [
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]
        );
        if ($user) {
            DB::commit();
            return $user;
        }
        DB::rollBack();
        throw new GeneralException(__('exceptions.backend.access.users.create_error'));
    }
}
