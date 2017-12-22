<?php

namespace BlogBundle\Event;

use BlogBundle\Entity\Message;
use Symfony\Component\EventDispatcher\Event;

class MessageEvent extends Event
{
    private $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}