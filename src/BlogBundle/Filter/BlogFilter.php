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
}
