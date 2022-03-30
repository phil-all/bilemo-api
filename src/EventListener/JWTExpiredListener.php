<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

/**
 * Listener to set a custom a response when expired JWT
 * @package App\EventListener
 */
class JWTExpiredListener
{
    /**
     * Set a custom response when expire JWT event
     *
     * @param JWTExpiredEvent $event
     *
     * @return void
     */
    public function onJWTExpired(JWTExpiredEvent $event): void
    {
        /** @var JWTAuthenticationFailureResponse */
        $response = $event->getResponse();

        $response->setMessage('Your token is expired, please login to renew it for one more hour validity.');
    }
}
