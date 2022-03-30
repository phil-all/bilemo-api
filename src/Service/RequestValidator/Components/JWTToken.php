<?php

namespace App\Service\RequestValidator\Components;

use Symfony\Component\HttpFoundation\Request;

/**
 * JWTToken trait
 * @package App\Service\RequestValidator
 */
trait JWTToken
{
    /**
     * Get a claim in token paylmoad by its name
     *
     * @param string $name
     *
     * @return boolean|integer|string
     */
    private function getInTokenPayload(string $name, Request $request): bool|int|string
    {
        return $this->getDecodePayload($request)[$name];
    }

    /**
     * Get token from request
     *
     * @return string
     */
    private function getToken(Request $request): string
    {
        return preg_replace('/Bearer /', '', $request->headers->get('authorization'));
    }

    /**
     * Decode token payload
     *
     * @return array
     */
    private function getDecodePayload(Request $request): array
    {
        $token = explode('.', $this->getToken($request));

        $data = mb_convert_encoding(
            $token[1],
            'UTF-8',
            'BASE64'
        );

        return json_decode($data, true);
    }
}
