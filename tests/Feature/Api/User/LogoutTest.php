<?php

namespace Tests\Feature\Api\User;

use App\Models\Auth\User;
use Database\Seeders\UsersTableSeeder;
use Tests\ApiTestCase;
use Tests\ProviderDataTrait;

class LogoutTest extends ApiTestCase
{
    use ProviderDataTrait;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return self::METHOD_POST;
    }

    /**
     * Url of method that will be tested
     *
     * @return string
     */
    protected function getUrl(): string
    {
        return '/user/logout';
    }

    /** @test */
    public function testLogout()
    {
        $this->seed(UsersTableSeeder::class);
        $user = User::where('email', 'user@nosend.net')->first();
        $this->loginUser($user);
        $this->send($this->getMethod(), $this->getUrl())
            ->assertStatus(204);
    }
}
