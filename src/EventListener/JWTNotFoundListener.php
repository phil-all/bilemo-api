<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;

/**
 * Listener to set a custom a response when not found JWT
 * @package App\EventListener
 */
class JWTNotFoundListener
{
    /**
     * Set a custom response when not found JWT event
     *
     * @param JWTNotFoundEvent $event
     *
     * @return void
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = json_encode([
            'error'  => 'Token is missing. Please store it as authentication in your header request',
        ]);

        $event->setResponse(new JsonResponse($data, 403));
    }
}
