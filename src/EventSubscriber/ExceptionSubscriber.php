<?php

namespace App\EventSubscriber;

use Throwable;
use ErrorException;
use Doctrine\DBAL\Exception\DriverException;
use Symfony\Component\HttpFoundation\Request;
use App\Service\SubscriberResponder\Responder;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use App\Service\RequestInspector\RequestInspector as Inspector;
use App\Service\RequestValidator\RequestValidator as Validator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

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
    public function onKernelException(ExceptionEvent $event): void
    {
        $message = 'Internal Server Error';
        $status  = 500;

        /** @var Request $request */
        $request = $event->getRequest();

        if ($event->getThrowable() instanceof IdentityProviderException) {
            /** @var IdentityProviderException $exception */
            $exception = $event->getThrowable();

            $message = $exception->getResponseBody();
            $status  = 400;
        }

        if ($event->getThrowable() instanceof DriverException) {
            $message = 'Bad Request, please check requested uri parameters';
            $status  = 400;
        }

        $this->validator->init($request);

        if ($event->getThrowable() instanceof NotFoundHttpException && $this->validator->isRouteExist()) {
            $message = 'The required ' . $this->inspector->getRessourceType($request) . ' does not exists.';
            $status  = 404;
        }

        if ($event->getThrowable() instanceof ErrorException) {
            $message = "Internal Server Error";
            $status  = 500;
        }

        if (!$event->getThrowable() instanceof AuthenticationException) {
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
