<?php

namespace App\Service\Google;

use App\Service\Google\AccessToken;
use App\Service\JWTTokenInspector\JWTTokenInspector;

/**
 * Google provider inspector
 * @package App\Service\Google
 */
class GoogleInspector
{
    /**
     * @var JWTTokenInspector
     */
    private JWTTokenInspector $jwt;

    /**
     * GoogleProvider constructor
     *
     * @param AccessToken       $accessToken
     * @param JWTTokenInspector $jwt
     */
    public function __construct(AccessToken $accessToken, JWTTokenInspector $jwt)
    {
        $jwt->setTokenFromThirdParty($accessToken->getJwtToken());

        $this->jwt = $jwt;
    }

    /**
     * Get client email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->jwt->getClaim('email');
    }

    /**
     * Get google id token to be used in clients requests
     *
     * @return string
     */
    public function getIdToken(): string
    {
        return $this->jwt->getToken();
    }

    /**
     * Get expiration UNIX timestamp
     *
     * @return integer
     */
    public function getExpires(): int
    {
        return $this->jwt->getClaim('exp');
    }
}
