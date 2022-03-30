<?php

namespace App\EventSubscriber;

use App\Service\RequestValidator\RequestValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Request subscriber
 * @package App\EventSubscriber
 */
class RequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestValidator
     */
    private RequestValidator $request;

    /**
     * RequestSubscriber constructor
     *
     * @param RequestValidator $request
     *
     * @return void
     */
    public function __construct(RequestValidator $request)
    {
        $this->request = $request;
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
        $this->request->init($event->getRequest());

        if ($this->request->isClientRessourcesEntryPoint() && !$this->request->isClientSameOnUri()) {
            $message = [
                'error' => 'You are not the user specified in client id, ressoureces requeted are not your own.',
            ];

            /** @var JsonResponse $response */
            $response = new JsonResponse($message, 403);

            $response->headers->set('Content-Type', 'application/ld+json');

            $event->setResponse($response);
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
