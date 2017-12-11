<?php

namespace BlogBundle\Filter;

use Symfony\Component\Validator\Constraints as Assert;

class MessageFilter
{

    /**
     * @var string
     */
    protected $name;
	/**
	 * @var string
	 */
	protected $message;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	}
}
