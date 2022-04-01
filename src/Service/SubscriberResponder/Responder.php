<?php

namespace App\Service\SubscriberResponder;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Get responses for event subscriber
 * @package App\Service\SubscriberResponder
 */
class Responder
{
    /**
     * Get error JsonResponse with status code
     *
     * @param string  $message
     * @param integer $statusCode
     *
     * @return JsonResponse
     */
    public function getErrorJsonResponse(string $message, int $statusCode): JsonResponse
    {
        $message = [
            'error' => $message,
        ];

        /** @var JsonResponse $response */
        $response = new JsonResponse($message, $statusCode);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
