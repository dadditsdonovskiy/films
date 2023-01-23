<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

return [
    'validation' => [
        [
            'dataComment' => 'Check change email with empty fields',
            'request' => [
                'email' => '',
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'Email cannot be blank.',
                    ],
                ],
            ],
        ],
        [
            'dataComment' => 'Change email with invalid email',
            'request' => [
                'email' => 'mailnosend.net',
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'Email is not a valid email address.',
                    ],
                ],
            ],
        ],
        [
            'dataComment' => 'Change email already exist in system',
            'request' => [
                'email' => 'broker1@nosend.net',
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'Email has already been taken.',
                    ],
                ],
            ],
        ],
        [
            'dataComment' => 'Change email invalid data type format',
            'request' => [
                'email' => 123,
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
                ],
            ],
        ]
    ],
];
