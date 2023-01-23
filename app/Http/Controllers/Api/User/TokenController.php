<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\TokenList;
use App\Http\Resources\Api\Auth\AccessTokenDetailsResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use function __;
use function auth;
use function response;

class TokenController extends Controller
{
    /**
     * @param TokenList $request
     * @return Response
     */
    public function index(TokenList $request): AnonymousResourceCollection
    {
        $perPage = $request->get('perPage', 20);
        $query = auth()->user()->tokens()->orderBy('id', 'desc');
        return AccessTokenDetailsResource::collection($query->paginate($perPage));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        $token = auth()->user()->tokens()->where(['id' => $id])->first();
        if (!$token) {
            throw new NotFoundHttpException(__('exceptions.common.not_found'));
        }
        $token->delete();
        return response()->noContent();
    }
}
