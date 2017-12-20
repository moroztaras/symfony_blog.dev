<?php

namespace BlogBundle\Event;

use BlogBundle\Entity\Blog;
use Symfony\Component\EventDispatcher\Event;

class BlogEvent extends Event
{
    private $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function getBlog()
    {
        return $this->blog;
    }
}