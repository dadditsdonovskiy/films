<?php

namespace Tests\Feature\Api\User;

use App\Models\Auth\User;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;
use Tests\ProviderDataTrait;

/**
 * Class RegisterUserTest
 * @package Tests\Feature\Api\User
 */
class RegisterUserTest extends ApiTestCase
{
    use ProviderDataTrait;

    public function getMethod(): string
    {
        return self::METHOD_POST;
    }

    /**
     * Url of method that will be test
     * @return string
     */
    protected function getUrl(): string
    {
        return '/user/register';
    }

    /** @test */
    public function testRegisterUserValidData()
    {
        foreach ($this->getProviderData('successRegister') as $data) {
            $response = $this->send($this->getMethod(), $this->getUrl(), $data['request']);
            $response->assertStatus(200)
                ->assertJson(fn(AssertableJson $json) => $json->whereAllType($data['responseType']));
            $this->assertDatabaseHas('users', ['email' => $data['request']['email']]);
            $user = User::byEmail($data['request']['email'])->firstOrFail();
        }
    }

    /** @test */
    public function validation()
    {
        $this->seed(UsersTableSeeder::class);
        foreach ($this->getProviderData('validation') as $data) {
            $response = $this->send($this->getMethod(), $this->getUrl(), $data['request']);
            $response->assertStatus(422)
                ->assertJsonFragment($data['response']);
        }
    }
}

