<?php

namespace App\Events\Api\Auth\AccessToken;

use Illuminate\Queue\SerializesModels;

/**
 * Class UserCreated.
 */
class AccessTokenCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $accessToken;

    /**
     * @param $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
