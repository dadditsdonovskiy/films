<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public function __invoke()
    {
        return [
            'version' => [
                'major' => 0,
                'minor' => 1,
                'patch' => 1,
                'commit' => null,
            ],
            'parameters' => [],
        ];
    }
}
