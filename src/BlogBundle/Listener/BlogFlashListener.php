<?php

namespace BlogBundle\Listener;

use BlogBundle\BlogBundleEvents;
use BlogBundle\Event\BlogEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

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
            BlogBundleEvents::BLOG_CREATED => 'onFlashCreate',
            BlogBundleEvents::BLOG_EDIT => 'onFlashEdit',
            BlogBundleEvents::BLOG_DELETE => 'onFlashDelete',
        ];
    }

    public function onFlashCreate(BlogEvent $event)
    {
        $blog = $event->getBlog();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('Новий пост "%s" успішно добавлено!',$blog->getTitle())
        );
    }

    public function onFlashEdit(BlogEvent $event)
    {
        $blog = $event->getBlog();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('Пост "%s" змінений!',$blog->getTitle())
        );
    }

    public function onFlashDelete(BlogEvent $event)
    {
        $blog = $event->getBlog();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('Пост "%s" видалений!',$blog->getTitle())
        );
    }
}


