<?php

declare(strict_types=1);

namespace App\Models\Sanctum;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    /**
     * Calculate token expired time (if it set in config)
     * @return int|null
     */
    public function getExpiredAt(): ?int
    {
        $expiration = config('sanctum.expiration');
        return $expiration ? $this->created_at->unix() + $expiration * 60 : null;
    }
}
