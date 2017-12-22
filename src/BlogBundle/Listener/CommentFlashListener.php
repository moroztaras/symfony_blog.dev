<?php

namespace BlogBundle\Listener;

use BlogBundle\BlogBundleEvents;
use BlogBundle\Event\CommentEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class CommentFlashListener implements EventSubscriberInterface
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    public static function getSubscribedEvents()
    {
        return [
            BlogBundleEvents::COMMENT_DELETE => 'onFlashDelete',
        ];
    }

    public function onFlashDelete(CommentEvent $event)
    {
        $comment = $event->getComment();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('Коментарій від "%s" видалений!',$comment->getUser())
        );
    }
}


