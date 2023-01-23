<?php

namespace Tests\Feature\Api\User;

use App\Models\Auth\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\UsersTableSeeder;
use Tests\ApiTestCase;
use Tests\PermissionTestTrait;
use Tests\ProviderDataTrait;

class ChangePasswordTest extends ApiTestCase
{
    use ProviderDataTrait,
        PermissionTestTrait;

    public function getMethod():string
    {
        return self::METHOD_PATCH;
    }

    /**
     * Url of method that will be test
     * @return string
     */
    protected function getUrl(): string
    {
        return '/user/change-password';
    }

    /** @test */
    public function testLoginUserChangePassword()
    {
        $this->seed(UsersTableSeeder::class);
        $user = User::where('email', 'user@nosend.net')->first();
        $this->loginUser($user);

        foreach ($this->getProviderData('change') as $data) {
            $response = $this->send($this->getMethod(), $this->getUrl(), $data['request']);
            $response->assertStatus(204)
                ->assertNoContent();
        }
        $this->post('/user/login', ['email' => 'user@nosend.net', 'password' => 'New_password0'])
            ->assertStatus(201);
    }

    /** @test */
    public function testResetPasswordValidation()
    {
        $this->seed(UsersTableSeeder::class);
        $user = User::where('email', 'user@nosend.net')->first();
        $this->loginUser($user);

        foreach ($this->getProviderData('validation') as $data) {
            $response = $this->send($this->getMethod(), $this->getUrl(), $data['request']);
            $response->assertStatus(422)
                ->assertJsonFragment($data['response']);
        }
    }

    /** @test */
    public function unauthorized()
    {
        $response = $this->send($this->getMethod(), $this->getUrl());
        $response->assertStatus(401);
    }
}
