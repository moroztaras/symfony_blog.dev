<?php

namespace BlogBundle\Filter;

use Symfony\Component\Validator\Constraints as Assert;

class CommentFilter
{
    /**
     * @var string
     */
    protected $comment;

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}
