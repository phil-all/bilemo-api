<?php

namespace App\Service\RequestValidator;

use Symfony\Component\HttpFoundation\Request;
use App\Service\RequestValidator\Components\Checker;

/**
 * Used to validate request
 * @package App\Service\RequestValidator
 */
class RequestValidator
{
    use \App\Service\RequestValidator\Components\JWTToken;

    /**
     * @var Checker
     */
    private Checker $checker;

    /**
     * RequestValidator constructor
     *
     * @param Checker $checker
     */
    public function __construct(Checker $checker)
    {
        $this->checker = $checker;
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
        $this->checker->setRequest($request);

        return $this;
    }

    /**
     * Check if uri is a client ressources entry point
     *
     * @return boolean
     */
    public function isClientRessourcesEntryPoint(): bool
    {
        return $this->checker->routeCheck();
    }

    /**
     * Check if Client identified by its token is the same as mentioned in uri
     *
     * @return boolean
     */
    public function isClientSameOnUri(): bool
    {
        return $this->checker->ownerIdcheck();
    }
}
