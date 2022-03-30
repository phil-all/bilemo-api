<?php

namespace App\Service\RequestValidator\Components;

use Symfony\Component\HttpFoundation\Request;

/**
 * Checker class
 * @package App\Service\RequestValidator
 */
class Checker
{
    use \App\Service\RequestValidator\Components\JWTToken;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * Set the request
     *
     * @param Request $request
     *
     * @return void
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Checks if route correspond to client part
     *
     * @return boolean
     */
    public function routeCheck(): bool
    {
        return str_contains($this->getInParameterBag('_route'), '_client_');
    }

    /**
     * Compare client id from uri with id from token
     *
     * @return boolean
     */
    public function ownerIdcheck(): bool
    {
        return (int)$this->getInParameterBag('id') === $this->getInTokenPayload('id', $this->request);
    }

    /**
     * Get the request attributes parameters by their name
     *
     * @param string $name
     *
     * @return string
     */
    private function getInParameterBag(string $name): string
    {
        return $this->request->attributes->get($name);
    }
}
