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
     * Get the request attributes parameter by its name
     *
     * @param string $name
     *
     * @return null|string
     */
    public function getParameter(string $name): ?string
    {
        return $this->request->attributes->get($name);
    }

    /**
     * Get route from parameter bag
     *
     * @return string|null
     */
    public function getRoute(): ?string
    {
        return $this->getParameter('_route');
    }

    /**
     * Get request query string parameters ($_GET).
     *
     * @param string $name
     *
     * @return string
     */
    public function getQueryParameter(string $name): string
    {
        return (string)$this->request->query->get($name);
    }
}
