<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

use App\Models\Auth\User;
use App\Models\Auth\UserToken;
use App\Services\Auth\ResetPasswordService;

$user = User::factory()->create(['email' => 'john@nosend.net']);
$userToken = UserToken::factory()->create([
    //'value' => $user->email,
    'user_id' => $user->id,
    'action' => UserToken::ACTION_EMAIL_VERIFICATION,
]);

return [
    'reset' => [
        [
            'dataComment' => 'Check change password',
            'request' => [
                'resetToken' => $userToken->token,
                'password' => 'Password_0',
                'confirmPassword' => 'Password_0',
                'email' => $user->email,
            ]
        ]
    ],
    'validation' => [
        [
            'dataComment' => 'Check reset password for diff confirm passwords',
            'request' => [
                'resetToken' => $userToken->token,
                'password' => 'Password_0',
                'confirmPassword' => 'Password_1',
                'email' => $user->email,
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' =>'password_confirmation',
                        'message' => 'Password confirmation must be equal to password.',
                    ],
                ]
            ]
        ],
        [
            'dataComment' => 'Check reset password with empty fields',
            'request' => [
                'resetToken' => '',
                'password' => '',
                'confirmPassword' => '',
                'email' => '',
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'Email cannot be blank.',
                    ],
                    [
                        'field' => 'password',
                        'message' => 'Password cannot be blank.',
                    ],
                    [
                        'field' => 'resetToken',
                        'message' => 'Reset token cannot be blank.',
                    ]
                ]
            ]
        ],
        [
            'dataComment' => 'Check reset password with invalid password field',
            'request' => [
                'resetToken' => $userToken->token,
                'password' => '123',
                'password_confirmation' => '123',
                'email' => $user->email,
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' =>'password',
                        'message' => 'The password should contain at least 8 symbols, one upper case, and one number.',
                    ],
                    [
                        'field' =>'password_confirmation',
                        'message' => 'The password confirmation should contain at least 8 symbols, one upper case, and one number.',
                    ]
                ] ,
            ],
        ]
    ]
];
