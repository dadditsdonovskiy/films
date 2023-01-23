<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

return [
    'successLogin' => [
        [
            'dataComment' => 'Check user can successfully login registered via email',
            'request' => [
                'email' => 'user@nosend.net',
                'password' => 'passWORD1',
            ],
            'response' => [
            ],
            'responseType' => [
                'message' => 'string',
                'result.expiredAt' => 'integer',
                'result.token' => 'string',
            ],
        ]
    ],
    'validation' => [
        [
            'dataComment' => 'Check login with empty fields',
            'request' => [
                'email' => '',
                'password' => '',
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
                ],
            ],
        ],
        [
            'dataComment' => 'Check login with invalid data',
            'request' => [
                'email' => 'notExist@nosend.net',
                'password' => 'passWORD1',
            ],
            'response' => [
                'message' => 'Unprocessable Entity',
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'Incorrect email or password',
                    ],
                ],
            ],
        ],
        [
            'dataComment' => 'Check invalid data types',
            'request' => [
                'email' => 122121212,
                'password' => 123123213123,
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'The email must be a string.',
                    ],
                    [
                        'field' => 'email',
                        'message' => 'Email is not a valid email address.',
                    ],
                    [
                        'field' => 'password',
                        'message' => 'The password must be a string.',
                    ],
                ],
            ],
        ],
    ],
];
