<?php

namespace Tests\Feature\Api\Config;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;
use Tests\ProviderDataTrait;

class ConfigTest extends ApiTestCase
{
    use ProviderDataTrait;

    public function getMethod():string
    {
        return self::METHOD_GET;
    }

    /**
     * Url of method that will be test
     * @return string
     */
    protected function getUrl(): string
    {
        return '/config';
    }

    public function testTokenSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        foreach ($this->getProviderData('success') as $data) {
            $response = $this->send($this->getMethod(), $this->getUrl(), $data['request']);
            $response->assertStatus(200)
                ->assertJson(fn(AssertableJson $json) => $json->whereAllType($data['responseType']));
        }
    }
}
