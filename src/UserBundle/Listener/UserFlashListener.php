<?php

namespace BlogBundle\Listener;

use BlogBundle\BlogBundleEvents;
use BlogBundle\Event\BlogEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\UserBundleEvents;

class BlogFlashListener implements EventSubscriberInterface
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    public static function getSubscribedEvents()
    {
        return [
            UserBundleEvents::BLOG_CREATED => 'onFlashCreate',
        ];
    }

    public function onFlashCreate(BlogEvent $event)
    {
        $blog = $event->getBlog();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('Новий пост "%s" успішно добавлено!', $blog->getTitle())
        );
    }
}