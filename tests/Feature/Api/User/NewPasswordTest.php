<?php

namespace Tests\Feature\Api\User;

use Tests\ApiTestCase;
use Tests\ProviderDataTrait;

class NewPasswordTest extends ApiTestCase
{
    use ProviderDataTrait;

    public function getMethod():string
    {
        return self::METHOD_POST;
    }

    /**
     * Url of method that will be test
     * @return string
     */
    protected function getUrl(): string
    {
        return '/user/new-password';
    }

    /** @test */
    public function testSetNewPassword()
    {
        $this->markTestSkipped();
        foreach ($this->getProviderData('reset') as $data) {
            $response = $this->send($this->getMethod(), $this->getUrl(), $data['request']);
            var_dump($data['request']);
            $response->dump();
            $response->assertStatus(204);
        }
        $this->post('/user/login', ['email' => 'john@nosend.net', 'password' => 'Password_0'])->assertStatus(201);
    }

    /** @test */
    public function testResetPasswordValidation()
    {
        $this->markTestSkipped();
        foreach ($this->getProviderData('validation') as $data) {
            $response = $this->send($this->getMethod(), $this->getUrl(), $data['request']);
            $response->assertStatus(422)
                ->assertJsonFragment($data['response']);
        }
    }
}
