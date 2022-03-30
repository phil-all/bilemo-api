<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

/**
 * Listener to set a custom response when JWT authentication failure event
 * @package App\EventListener
 */
class JWTAuthenticationFailureListener
{
    /**
     * Set a custom response when JWT authentication failure event
     *
     * @param AuthenticationFailureEvent $event
     *
     * @return void
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event): void
    {
        $data = json_encode([
            'Bad credentials, please verify that your username/password are correctly set',
        ]);

        $event->setResponse(new JsonResponse($data, 401));
    }
}
