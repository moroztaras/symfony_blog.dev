<?php

namespace BlogBundle\Listener;

use BlogBundle\BlogBundle;
use BlogBundle\BlogBundleEvents;
use BlogBundle\Event\BlogEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class FlashListener implements EventSubscriberInterface
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    public static function getSubscribedEvents()
    {
        return [
            BlogBundleEvents::BLOG_CREATED => 'onFlash'
        ];
    }

    public function onFlash(BlogEvent $event)
    {
        $blog = $event->getBlog();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('Новий пост "%s" успішно добавлено!',$blog->getTitle())
        );
    }
}


