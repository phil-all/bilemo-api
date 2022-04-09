<?php

namespace App\Service\Google;

use App\Service\Google\Provider;
use App\Service\Google\Authorization;
use League\OAuth2\Client\Token\AccessTokenInterface;

/**
 * Manage Google tokens
 * @package App\Service\Google
 */
class AccessToken
{
    /**
     * @var Provider
     */
    private Provider $provider;

    private Authorization $authorization;

    /**
     * AccessToken constructor
     *
     * @param Provider      $provider
     * @param Authorization $authorization
     */
    public function __construct(Provider $provider, Authorization $authorization)
    {
        $this->provider      = $provider;
        $this->authorization = $authorization;
    }

    /**
     * Get google access token
     *
     * @return AccessTokenInterface
     */
    public function getAccessToken(): AccessTokenInterface
    {
        return $this->getProvider()->getProvider()->getAccessToken('authorization_code', [
            'code' => $this->authorization->getAuthorizationCode(),
        ]);
    }

    /**
     * Get google JWT token
     *
     * @return string
     */
    public function getJwtToken(): string
    {
        return $this->getAccessToken()->getValues()['id_token'];
    }

    /**
     * Get provider
     *
     * @return Provider
     */
    private function getProvider(): Provider
    {
        return $this->provider;
    }
}
