<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */


return [
    'validation' => [
        [
            'dataComment' => 'Check verification with empty token',
            'request' => [
                'token' => '',
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' => 'token',
                        'message' => 'Token cannot be blank.',
                    ],
                ],
            ],
        ],
        [
            'dataComment' => 'Check verification with int type of token',
            'request' => [
                'token' => 123456,
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' => 'token',
                        'message' => 'The token must be a string.',
                    ],
                ],
            ],
        ],
        [
            'dataComment' => 'Check verification with int type of token',
            'request' => [
                'token' => '123456',
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' => 'token',
                        'message' => 'The token must be a string.',
                    ],
                ],
            ],
        ],
    ],
];
