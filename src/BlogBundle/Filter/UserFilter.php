<?php

namespace BlogBundle\Filter;

use Symfony\Component\Validator\Constraints as Assert;

class UserFilter
{
    /**
	 * @var string
	 */
	protected $username;

	/**
	 * @return string
	 */
	public function getUserName()
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 */
	public function setUserName($username)
	{
		$this->username = $username;
	}
}
