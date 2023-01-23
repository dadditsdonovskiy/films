<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */


return [
    'successVerification' => [
        [
            'dataComment' => 'Check success verification',
            'request' => [
            ],
            'response' => [
            ],
            'responseType' => [
                'message' => 'string',
                'result.expiredAt' => 'integer',
                'result.token' => 'string',
            ],
        ],
    ],
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
            'dataComment' => 'Check verification with short token',
            'request' => [
                'token' => 1,
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' => 'token',
                        'message' => 'The token must be 6 digits.',
                    ],
                ],
            ],
        ],
        [
            'dataComment' => 'Check verification with string token',
            'request' => [
                'token' => 'test',
            ],
            'response' => [
                'message' => 'The given data was invalid.',
                'result' => [
                    [
                        'field' => 'token',
                        'message' => 'The token must be 6 digits.',
                    ],
                    [
                        'field' => 'token',
                        'message' => 'Token must be an integer.',
                    ],
                ],
            ],
        ],
    ],
];
