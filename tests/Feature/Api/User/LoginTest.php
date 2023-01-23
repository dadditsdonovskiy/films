<?php

namespace Tests\Feature\Api\User;

use Database\Seeders\UsersTableSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;
use Tests\ProviderDataTrait;

class LoginTest extends ApiTestCase
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
        return '/user/login';
    }

    /** @test */
    public function testLoginValidData()
    {
        $this->seed(UsersTableSeeder::class);
        foreach ($this->getProviderData('successLogin') as $data) {
            $response = $this->send($this->getMethod(), $this->getUrl(), $data['request']);
            $response->assertCreated()
                ->assertJson(fn(AssertableJson $json) => $json->whereAllType($data['responseType']));
        }
    }

    /** @test */
    public function loginValidation()
    {
        $this->markTestSkipped();
        $this->seed(UsersTableSeeder::class);
        foreach ($this->getProviderData('validation') as $data) {
            $response = $this->send($this->getMethod(), $this->getUrl(), $data['request']);
            $response->assertStatus(422)
                ->assertJsonFragment($data['response']);
        }
    }
}
