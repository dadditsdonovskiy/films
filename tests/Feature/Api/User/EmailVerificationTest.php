<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use App\Models\Auth\User;
use App\Models\Auth\UserToken;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;
use Tests\ProviderDataTrait;

class EmailVerificationTest extends ApiTestCase
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
        return '/email/verification';
    }

    /** @test  */
    public function testSuccessVerified()
    {
        $user = User::factory()->create(
            [
                'email_verified_at' => null,
                'email' => 'john2@nosend.net'
            ]
        );

        $token = UserToken::factory()->create(
            [
                'user_id' => $user->id,
                'action' => UserToken::ACTION_EMAIL_VERIFICATION,
            ]
        );

        $response = $this->send($this->getMethod(), $this->getUrl(),['token' => $token->token,]);
        $response->assertStatus(204);
        $this->assertDatabaseMissing(
            'user_tokens',
            [
                'user_id' => $user->id,
                'action' => UserToken::ACTION_EMAIL_VERIFICATION
            ]
            );
        $this->assertDatabaseMissing('users', ['id' => $user->id, 'email_verified_at' => null]);
    }

    /** @test */
    public function validation() {

        $this->markTestSkipped();
        $user = User::factory()->create(
            [
                'email_verified_at' => null,
                'email' => 'john2@nosend.net'
            ]
        );

        UserToken::factory()->create(
            [
                'user_id' => $user->id,
                'action' => UserToken::ACTION_EMAIL_VERIFICATION,
            ]
        );

        foreach ($this->getProviderData('validation') as $data) {
            $response = $this->send($this->getMethod(), $this->getUrl(), $data['request']);
            $response->assertStatus(422)
                ->assertJsonFragment($data['response']);
        }
    }
}
