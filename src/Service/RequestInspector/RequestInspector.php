<?php

namespace App\Service\RequestInspector;

use Symfony\Component\HttpFoundation\Request;

/**
 * Inspect the request
 * @package App\Service\RequestInspector
 */
class RequestInspector
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * Get value of the request
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Set the request value
     *
     * @param Request $request
     *
     * @return void
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * Get the ressource type targeted by the route
     *
     * @param Request $request
     *
     * @return string|null
     */
    public function getRessourceType(Request $request): ?string
    {
        $route = $request->attributes->get('_route');

        return preg_replace('/(.)*_/', '', $route);
    }

    /**
     * Get the request attributes parameter by its name
     *
     * @param string $name
     *
     * @return null|string
     */
    public function getParameter(string $name): ?string
    {
        //dd($this->getInParameterBag('_route'));
        return $this->request->attributes->get($name);
    }
}
