<?php

namespace App\Service\JWTTokenInspector;

use Symfony\Component\HttpFoundation\Request;

/**
 * JWTToken Inspector
 * @package App\Service\JWTTokenInspector
 */
class JWTTokenInspector
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var string
     */
    private string $token;

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
        $this->setToken();
    }

    /**
     * Get a claim in token payload by its name
     *
     * @param string $name
     *
     * @return boolean|integer|string
     */
    public function getClaim(string $name): bool|int|string
    {
        return $this->getDecodePayload()[$name];
    }

    /**
     * Get token value
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Set third party Token
     *
     * @param string $token
     *
     * @return self
     */
    public function setTokenFromThirdParty(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Decode token payload
     *
     * @return array
     */
    public function getDecodePayload(): array
    {
        $token = explode('.', $this->getToken());

        $data = mb_convert_encoding(
            $token[1],
            'UTF-8',
            'BASE64'
        );

        return json_decode($data, true);
    }

    /**
     * Get a cleaned token
     *
     * @return string
     */
    public function getCleanedToken(): string
    {
        return preg_replace('/Bearer /', '', $this->request->headers->get('authorization'));
    }

    /**
     * Set token from request headers
     *
     * @return void
     */
    private function setToken(): void
    {
        $this->token = $this->getCleanedToken();
    }
}
