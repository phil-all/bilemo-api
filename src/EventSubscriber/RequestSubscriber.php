<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use App\Service\SubscriberResponder\Responder as Responder;
use App\Service\RequestValidator\RequestValidator as Validator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Request subscriber
 * @package App\EventSubscriber
 */
class RequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var Validator
     */
    private Validator $validator;

    /**
     * @var Responder
     */
    private Responder $responder;

    /**
     * RequestSubscriber constructor
     *
     * @param Validator $validator
     * @param Responder $responder
     */
    public function __construct(Validator $validator, Responder $responder)
    {
        $this->validator = $validator;
        $this->responder = $responder;
    }

    /**
     * Make action when request event
     *
     * @param RequestEvent $event
     *
     * @return void
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $this->validator->init($event->getRequest());

        if ($this->validator->isClientRessourcesEntryPoint() && !$this->validator->isClientSameOnUri()) {
            $message = 'You are not the user specified in client id uri part. Ressoureces requested are not your own.';

            $event->setResponse($this->responder->getErrorJsonResponse($message, 403));
        }
    }

    /**
     * Get the subscribed Event: onKernelRequest
     *
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }
}
