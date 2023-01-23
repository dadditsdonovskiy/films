<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Auth\CreateUserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateUser extends Command
{
    protected $name = 'user:create';

    protected $description = 'Create user';

    protected $signature = 'user:create
                        {email : Email user}
                        {password : Password user}';

    /**
     * @param CreateUserService $createUserService
     * @return int
     * @throws \App\Exceptions\GeneralException
     */
    public function handle(CreateUserService $createUserService): int
    {
        $data = [
            'email' => $this->argument('email'),
            'password' => $this->argument('password')
        ];
        $validator = Validator::make(
            $data,
            [
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', Password::defaults()]
            ]
        );

        if ($validator->fails()) {
            $this->line('User not created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = $createUserService->create($data);
        $user->markEmailAsVerified();

        $this->info('User success created.');
        $this->line('Login: ' . $user->email);
        $this->line('Password: ' . $data['password']);

        return self::SUCCESS;
    }
}
