<?php

namespace UserBundle\Listener;

use UserBundle\UserBundleEvents;
use UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class UserFlashListener implements EventSubscriberInterface
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    public static function getSubscribedEvents()
    {
        return [
            UserBundleEvents::USER_REGISTER => 'onFlashRegister',
            UserBundleEvents::USER_EDIT => 'onFlashEdit',
            UserBundleEvents::USER_RECOVER_PASSWORD => 'onFlashRecoverPassword',
        ];
    }

    public function onFlashRegister(UserEvent $event)
    {
        $user = $event->getUser();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('Новий користувач - %s %s успішно зарестрований!', $user->getAccount()->getLastName(), $user->getAccount()->getFirstName())
        );
    }

    public function onFlashEdit(UserEvent $event)
    {
        $user = $event->getUser();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('Зміни збережено. Нові дані відображено на сторінці профіля.')
        );
    }

    public function onFlashRecoverPassword(UserEvent $event)
    {
        $user = $event->getUser();
        $this->session->getFlashBag()->add(
            'success',
            sprintf('Новий пароль успішно змінений!')
        );
    }
}