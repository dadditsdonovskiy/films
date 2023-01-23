<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

class CurrentController extends Controller
{
    public function __invoke()
    {
        return auth()->user();
    }
}
