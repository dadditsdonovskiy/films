<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class SwaggerController extends Controller
{
    public function json()
    {
        return file_get_contents(resource_path('swagger/swagger.json'));
    }
}
