<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace Tests;

use App\Models\Auth\User;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

trait PermissionTestTrait
{
    use RefreshDatabase;

    /**
     * @param array $userIds
     */
    protected function roles(array $userIds): void
    {
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            $this->loginUser($user);
            $response = $this->send($this->getMethod(), $this->getUrl())->assertForbidden();
        }
    }
}
