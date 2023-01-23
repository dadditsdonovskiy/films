<?php

namespace App\Http\Controllers\Api\StaticPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StaticPage\StaticPageList;
use App\Http\Resources\Api\StaticPage\StaticPageResource;
use App\Models\StaticPage\StaticPage;

class StaticPageController extends Controller
{
    public function index(StaticPageList $staticPageListRequest)
    {
        $perPage = $staticPageListRequest->get('perPage', 20);

        return StaticPageResource::collection(StaticPage::query()->paginate($perPage));
    }

    public function view(string $slug)
    {
        $staticPage = StaticPage::query()->where('slug', '=', $slug)->firstOrFail();

        return new StaticPageResource($staticPage);
    }
}
