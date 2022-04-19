<?php

namespace App\EventSubscriber;

use ErrorException;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Component\HttpFoundation\Request;
use App\Service\SubscriberResponder\Responder;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use App\Service\RequestValidator\RequestValidator as Validator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\ControllerDoesNotReturnResponseException;

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
     * ExceptionSubscriber contructor
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
     * Make action when exception event
     *
     * @param ExceptionEvent $event
     *
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $message = null;
        $status  = null;

        /** @var Request $request */
        $request = $event->getRequest();

        if ($event->getThrowable() instanceof BadRequestHttpException) {
            $message = 'Bad Request, please check your body request';
            $status  = 400;
        }

        if ($event->getThrowable() instanceof DriverException) {
            $message = 'Bad Request, please check requested uri parameters';
            $status  = 400;
        }

        $this->validator->init($request);

        if ($event->getThrowable() instanceof NotFoundHttpException) {
            $message = 'Requested ressource may not exist. It can not be found.';
            $status  = 404;
        }

        if ($event->getThrowable() instanceof MethodNotAllowedHttpException) {
            $message = "HTTP method not allowed";
            $status  = 405;
        }

        if (
            $event->getThrowable() instanceof ErrorException
            ||
            $event->getThrowable() instanceof ControllerDoesNotReturnResponseException
        ) {
            $message = "Internal Server Error";
            $status  = 500;
        }

        if ($status !== null) {
            $event->setResponse($this->responder->getErrorJsonResponse($message, $status));
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
            ExceptionEvent::class => 'onKernelException',
        ];
    }
}
