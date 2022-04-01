<?php

namespace App\Service\RequestValidator;

use Symfony\Component\HttpFoundation\Request;
use App\Service\RequestValidator\Components\Checker;
use App\Service\JWTTokenInspector\JWTTokenInspector as JWT;
use App\Service\RequestInspector\RequestInspector as Inspector;

/**
 * Used to validate request
 * @package App\Service\RequestValidator
 */
class RequestValidator
{
    /**
     * @var Inspector
     */
    private Inspector $inspector;

    /**
     * @var JWT
     */
    private JWT $jwt;

    /**
     * RequestValidator constructor
     *
     * @param Inspector $inspector
     * @param JWT       $jwt
     */
    public function __construct(Inspector $inspector, JWT $jwt)
    {
        $this->inspector = $inspector;
        $this->jwt       = $jwt;
    }

    /**
     * Initialize the request in validator
     *
     * @param Request $request
     *
     * @return self
     */
    public function init(Request $request): self
    {
        $this->inspector->setRequest($request);
        $this->jwt->setRequest($request);

        return $this;
    }

    /**
     * Check if uri is a client ressources entry point
     *
     * @return boolean
     */
    public function isClientRessourcesEntryPoint(): bool
    {
        return str_contains($this->inspector->getParameter('_route'), '_client_');
    }

    /**
     * Check if Client identified by its token is the same as mentioned in uri
     *
     * @return boolean
     */
    public function isClientSameOnUri(): bool
    {
        return (int)$this->inspector->getParameter('id') === $this->jwt->getClaim('id');
    }

    /**
     * Check if request contain a route in parameter bag
     *
     * @return boolean
     */
    public function isRouteExist(): bool
    {
        return (null !== $this->inspector->getParameter('_route'));
    }
}
