<?php

namespace App\Console\Commands;

use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Console\Command;

use function config;

/**
 * Class ClearExpiredTokens
 * @package App\Console\Commands
 */
class ClearExpiredTokens extends Command
{
    /**
     * @var string
     */
    protected $signature = 'token:clear-expired';

    /**
     * @var string
     */
    protected $description = 'Remove expired tokens from db';

    public function handle()
    {
        $expiration = config('sanctum.expiration');
        if (!$expiration) {
            return;
        }
        PersonalAccessToken::where('created_at', '<', now()->subMinutes($expiration))->delete();
    }
}
