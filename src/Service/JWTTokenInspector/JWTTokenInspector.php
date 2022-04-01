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
     * Get token from request
     *
     * @return string
     */
    private function getToken(): string
    {
        return preg_replace('/Bearer /', '', $this->request->headers->get('authorization'));
    }

    /**
     * Decode token payload
     *
     * @return array
     */
    private function getDecodePayload(): array
    {
        $token = explode('.', $this->getToken());

        $data = mb_convert_encoding(
            $token[1],
            'UTF-8',
            'BASE64'
        );

        return json_decode($data, true);
    }
}
