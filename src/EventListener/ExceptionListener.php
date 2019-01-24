<?php

/*
 * This file is part of Symfony4 Test Project 2019.
 *
 * @author Omar Makled <omar.makled@aqarmap.com>
 */

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Exception\NotEmptyException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use ReflectionClass;
use Symfony\Component\Translation\TranslatorInterface;

class ExceptionListener
{
    /**
     * Translator instance.
     * 
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected $translator;

    /**
     * Event instance.
     * 
     * @var \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent
     */
    protected $event;

    /**
     * List of exceptions should report.
     *
     * @var []
     */
    protected $exceptions = [
        HttpException::class => Response::HTTP_BAD_REQUEST,
        NotEmptyException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
        UniqueConstraintViolationException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
    ];

    /**
     * Constructor.
     * 
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Hook on kernel exception.
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        foreach ($this->exceptions as $exception => $code) {
            if ($event->getException() instanceof $exception) {
                $message = (new ReflectionClass($exception))->getShortName();
                $event->setResponse(new JsonResponse([
                    'error' => $this->translator->trans($message, [], 'exceptions'),
                ], $code));
            }
        }
    }
}
