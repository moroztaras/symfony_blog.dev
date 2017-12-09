<?php

namespace BlogBundle\Filter;

use Symfony\Component\Validator\Constraints as Assert;

class BlogFilter
{

	/**
	 * @var string
	 */
	protected $title;

    	/**
         * @var \DateTime
         */
	protected $created;

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}
    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }
}
