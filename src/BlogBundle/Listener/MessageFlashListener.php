<?php

namespace BlogBundle\Listener;

use BlogBundle\BlogBundleEvents;
use BlogBundle\Event\MessageEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class MessageFlashListener implements EventSubscriberInterface
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    public static function getSubscribedEvents()
    {
        return [
            BlogBundleEvents::MESSAGE_CREATE => 'onFlashCreate',
            BlogBundleEvents::MESSAGE_DELETE => 'onFlashDelete',
        ];
    }

    public function onFlashCreate(MessageEvent $event)
    {
        $message = $event->getMessage();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('%s! Повідомлення успішно відправлено!',$message->getName())
        );
    }

    public function onFlashDelete(MessageEvent $event)
    {
        $message = $event->getMessage();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('Повідомлення від "%s" видалено!',$message->getName())
        );
    }
}


