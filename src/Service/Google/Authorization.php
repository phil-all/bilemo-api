<?php

namespace App\Service\Google;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Authorization class
 * @package App\Service\Google
 */
class Authorization
{
    /**
     * @var RequestStack
     */
    private RequestStack $request;

    /**
     * Authorization constructor
     *
     * @param RequestStack $request
     */
    public function __construct(RequestStack $request)
    {
        $this->request = $request;
    }

    /**
     * get authorization code from request
     *
     * @return string
     */
    public function getAuthorizationCode(): string
    {
        return $this->request->pop()->query->get('code');
    }
}
