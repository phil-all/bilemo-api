<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\Request;
use App\Service\SubscriberResponder\Responder;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use App\Service\RequestInspector\RequestInspector as Inspector;
use App\Service\RequestValidator\RequestValidator as Validator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Exception subscriber
 * @package App\EventSubscriber
 */
class ExceptionSubscriber implements EventSubscriberInterface
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
     * @var Inspector
     */
    private Inspector $inspector;

    /**
     * ExceptionSubscriber contructor
     *
     * @param Validator $validator
     * @param Responder $responder
     * @param Inspector $inspector
     */
    public function __construct(Validator $validator, Responder $responder, Inspector $inspector)
    {
        $this->validator = $validator;
        $this->responder = $responder;
        $this->inspector = $inspector;
    }

    /**
     * Make action when exception event
     *
     * @param ExceptionEvent $event
     *
     * @return void
     */
    public function onKernelRequest(ExceptionEvent $event): void
    {
        /** @var Request $request */
        $request = $event->getRequest();

        $this->validator->init($request);

        if ($event->getThrowable() instanceof NotFoundHttpException && $this->validator->isRouteExist()) {
            $message = 'The required ' . $this->inspector->getRessourceType($request) . ' does not exists.';

            $event->setResponse($this->responder->getErrorJsonResponse($message, 404));
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
            ExceptionEvent::class => 'onKernelRequest',
        ];
    }
}
