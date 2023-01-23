<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

use Illuminate\Support\Str;

$randomStr = Str::random(256);

return [
    'successRegister' => [
        [
            'dataComment' => 'Check register as pet store',
            'request' => [
                'email' => 'petstore@nosend.net',
                'password' => 'passWORD1'
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
            'dataComment' => 'Check create user with empty fields',
            'request' => [
                'email' => '',
                'password' => ''
            ],
            'response' => [
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'Email cannot be blank.',
                    ],
                    [
                        'field' => 'password',
                        'message' => 'Password cannot be blank.',
                    ]
                ]
            ]
        ],
        [
            'dataComment' => 'Check register wih invalid data',
            'request' => [
                'email' => 'testnosend.net',
                'password' => '123',
            ],
            'response' => [
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'Email is not a valid email address.',
                    ],
                    [
                        'field' => 'password',
                        'message' => 'Password  should contain at least 8  character(s).',
                    ],
                ]
            ]
        ],
        [
            'dataComment' => 'Check register wih not unique email',
            'request' => [
                'email' => 'user@nosend.net',
                'password' => 'passWORD1',

            ],
            'response' => [
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'Email has already been taken.',
                    ],
                ]
            ]
        ],
        [
            'dataComment' => 'Check create user with invalid data types',
            'request' => [
                'email' => 123,
                'password' => 123,
            ],
            'response' => [
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
                    [
                        'field' => 'password',
                        'message' => 'Password  should contain at least 8  character(s).',
                    ],
                ]
            ]
        ],
    ]
];
