<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'token' => $this->plainTextToken,
            'expiredAt' => $this->resource?->accessToken->getExpiredAt(),
        ];
    }
}
