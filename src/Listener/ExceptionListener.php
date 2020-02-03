<?php

namespace App\Listener;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener  extends AbstractController implements ExceptionListenerInterface
{
    public function __construct(RouterInterface $router) {
        $this->router = $router;
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event) {
        $exception = $event->getException();
        $sRoute = 'home';
        if ($exception instanceof AccessDeniedHttpException) {
            $response = new RedirectResponse($this->router->generate('logout'));
            $event->setResponse($response);
        }
        if ($exception instanceof NotFoundHttpException) {
            $response = new RedirectResponse($this->router->generate('home'));
            $event->setResponse($response);
        }
        //return $event;
    }
}
