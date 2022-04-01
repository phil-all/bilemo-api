<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

/**
 * Listener to set a custom a response when invalid JWT
 * @package App\EventListener
 */
class JWTInvalidListener
{
    /**
     * Set a custom response when invalid JWT event
     *
     * @param JWTInvalidEvent $event
     *
     * @return void
     */
    public function onJWTInvalid(JWTInvalidEvent $event): void
    {
        $response = new JWTAuthenticationFailureResponse(
            'Your token is invalid, please login again to get a new one',
            403
        );

        $event->setResponse($response);
    }
}
