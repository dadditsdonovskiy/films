<?php

namespace Tests\Feature\Api\User;

use App\Models\Auth\User;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;
use Tests\ProviderDataTrait;

class CurrentTest extends ApiTestCase
{
    use ProviderDataTrait;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return self::METHOD_GET;
    }

    /**
     * Url of method that will be tested
     *
     * @return string
     */
    protected function getUrl(): string
    {
        return '/user/current';
    }

    /** @test */
    public function testCurrent()
    {
        $this->seed(UsersTableSeeder::class);
        $user = User::where('email', 'user@nosend.net')->first();
        $this->loginUser($user);
        $response = $this->send($this->getMethod(), $this->getUrl());
        $response->assertSuccessful()
            ->assertJson(fn(AssertableJson $json) => $json->whereAllType(
                [
                    'message' => 'string',
                    'result.email' => 'string',
                ]
            ));
    }

    /** @test */
    public function unauthorized()
    {
        $response = $this->send($this->getMethod(), $this->getUrl());
        $response->assertStatus(401);
    }
}
