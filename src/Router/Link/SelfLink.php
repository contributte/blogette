<?php

namespace Blogette\Router\Link;

use Blogette\Router\Router;

final class SelfLink implements Link
{

	/** @var Router */
	private $router;

	/** @var array */
	private $options;

	/**
	 * @param Router $router
	 * @param array $options
	 */
	public function __construct(Router $router, array $options = [])
	{
		$this->router = $router;
		$this->options = $options;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->router->construct('/', $this->options);
	}

}
