<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */

return [
    'change' => [
        [
            'dataComment' => 'Check change password',
            'request' => [
                'password' => 'New_password0'
            ],
        ]
    ],
    'validation' => [
        [
            'dataComment' => 'Check change password with empty fields',
            'request' => [
                'password' => '',
            ],
            'response' => [
                'result' => [
                    [
                        'field' =>'password',
                        'message' => 'Password cannot be blank.',
                    ]
                ]
            ]
        ],
        [
            'dataComment' => 'Check change password with incorrect data type and value',
            'request' => [
                'password' => 123
            ],
            'response' => [
                'result' => [
                    [
                        'field' =>'password',
                        'message' => 'The password must be a string.',
                    ],
                    [
                        'field' =>'password',
                        'message' => 'Password  should contain at least 8  character(s).',
                    ],
                ]
            ]
        ]
    ]
];
