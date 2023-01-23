<?php

namespace Database\Factories\Auth;

use App\Models\Auth\UserToken;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class UserTokenFactory
 * @package Database\Factories\Auth
 */
class UserTokenFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = UserToken::class;

    public function definition(): array
    {
        return [
            'token' => $this->faker->unique()->text(32),
            'expires_at' => time() + 3600,
        ];
    }
}
