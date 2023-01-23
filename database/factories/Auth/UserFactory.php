<?php

namespace Database\Factories\Auth;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\en_US\Person;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserFactory
 * @package Database\Factories\Auth
 */
class UserFactory extends Factory
{
     public const DEFAULT_PASSWORD = 'passWORD1';

    /**
     * @var string
     */
    protected $model = User::class;

    public function definition(): array {
        //https://stackoverflow.com/a/33445024/1202097
        $this->faker->addProvider(new Person($this->faker));
        return [
            'name' => $this->faker->name,
            'email' => preg_replace('/@example\..*/', '@nosend.net', $this->faker->unique()->safeEmail),
            'email_verified_at' => $this->faker->dateTime(),
            'password' => Hash::make(self::DEFAULT_PASSWORD),
            'remember_token' => $this->faker->text(10),
            'created_at' => time(),
            'updated_at' => time()
        ];
    }
}
