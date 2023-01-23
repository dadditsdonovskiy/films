<?php
/**
 * Copyright © 2020 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace Tests\Feature\Api\User;

use Tests\ApiTestCase;
use Tests\ProviderDataTrait;

class EmailResendTest extends ApiTestCase
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
        return '/email/resend';
    }

    public function testSuccessResend()
    {
        foreach ($this->getProviderData('resend') as $data) {
            $response = $this->send($this->getMethod(),$this->getUrl(), $data['request']);
            $response->assertStatus(204)
                ->assertNoContent();
        }
    }

    public function testResendEmailValidation()
    {
        foreach ($this->getProviderData('validate') as $data) {
            $response = $this->send($this->getMethod(),$this->getUrl(), $data['request']);
            $response->assertStatus(422)
                ->assertJsonFragment($data['response']);
        }
    }
}
