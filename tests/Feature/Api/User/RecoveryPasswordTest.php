<?php

namespace Tests\Feature\Api\User;

use App\Models\Auth\User;
use Database\Seeders\UsersTableSeeder;
use Tests\ApiTestCase;
use Tests\ProviderDataTrait;

/**
 * Class RecoveryPasswordTest
 * @package Tests\Feature\Api\User
 */
class RecoveryPasswordTest extends ApiTestCase
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
        return '/user/recovery-password';
    }

    /**
     * @test
     * @throws \Exception
     */
    public function testRecoveryPassword()
    {
        $this->seed(UsersTableSeeder::class);
        $user = User::factory()->create([
            'email' => 'test1@nosend.net',
        ]);
        $this->send($this->getMethod(), $this->getUrl(), ['email' => $user->email,])
            ->assertNoContent();
    }

    /**
     * @test
     * @throws \Exception
     */
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
