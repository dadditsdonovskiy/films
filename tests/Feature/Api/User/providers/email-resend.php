<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

use App\Models\Auth\User;

$user = User::factory()->create(['email_verified_at' => time()]);
$user1 = User::factory()->create(['email_verified_at' => null]);

return [
    'resend' => [
        [
            'dataComment' => 'Check resend email',
            'request' => [
                'email' => $user1->email,
            ],
            'response' => [
            ]
        ],
    ],
    'validate' => [
        [
            'dataComment' => 'Check resend empty email',
            'request' => [
                'email' => '',
            ],
            'response' => [
                'field' => 'email',
                'message' => 'Email cannot be blank.'
            ]
        ],
        [
            'dataComment' => 'Check resend invalid email',
            'request' => [
                'email' => 'mailnosend.net',
            ],
            'response' => [
                'field' => 'email',
                'message' => 'Email is not a valid email address.'
            ]
        ]
    ]
];
