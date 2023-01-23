<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

return [
    'validation' => [
        [
            'dataComment' => 'Check reset with empty field',
            'request' => [
                'email' => '',
            ],
            'response' => [
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'Email cannot be blank.',
                    ],
                ],
            ],
        ],
        [
            'dataComment' => 'Check reset with invalid email',
            'request' => [
                'email' => 'emailNotExist@nosend.net',
            ],
            'response' => [
                'result' => [
                    [
                        'field' => 'email',
                        'message' => 'Email is invalid.',
                    ],
                ],
            ],
        ],
        [
            'dataComment' => 'Check reset with not valid email and data type',
            'request' => [
                'email' => 123,
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
                ],
            ],
        ],
    ],
];
