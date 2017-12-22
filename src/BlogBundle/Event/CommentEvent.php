<?php

namespace BlogBundle\Event;

use BlogBundle\Entity\Comment;
use Symfony\Component\EventDispatcher\Event;

class CommentEvent extends Event
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getComment()
    {
        return $this->comment;
    }
}