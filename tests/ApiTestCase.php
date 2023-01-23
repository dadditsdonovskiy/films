<?php

namespace Tests;

use App\Http\Middleware\ThrottleRequests;
use App\Models\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;

/**
 * Class TestCase.
 */
abstract class ApiTestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';

    public function send(string $method, string $url, array $data = [], array $headers = [])
    {
        switch ($method) {
            case self::METHOD_GET:
                return $this->call('GET', $url, $data);
            case self::METHOD_PUT:
                return $this->put($url, $data, $headers);
            case self::METHOD_POST:
                return $this->post($url, $data, $headers);
            case self::METHOD_PATCH:
                return $this->patch($url, $data, $headers);
            case self::METHOD_DELETE:
                return $this->delete($url, $data, $headers);
            default:
                throw new \Exception("Need to implement for method: $method");
        }
    }

    /**
     * Create an administrator.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    protected function createUser(array $attributes = [])
    {
        return User::factory()->create($attributes);
    }

    /**
     * Login the given administrator or create the first if none supplied.
     *
     * @param bool $user
     *
     * @return bool|mixed
     */
    protected function loginUser($user = false)
    {
        if (!$user) {
            $user = User::factory()->create();
        }
        Sanctum::actingAs($user);
        return $user;
    }
    public function prepareUrlForRequest($uri)
    {
        return parent::prepareUrlForRequest(config('api.prefix').$uri);
    }
    public function addUserAndLogin($email,$password){
        $user = $this->createUser([
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'remember_token' => Str::random(10),
        ]);
        return $this->loginUser($user);
    }
    public function setUp():void {
        parent::setUp();
        Notification::fake();
        $this->withoutMiddleware(ThrottleRequests::class);
    }

}