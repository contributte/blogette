<?php

namespace Blogette\Router\Link;

use Blogette\Provider\Providing\LinkProviding;
use Blogette\Router\Router;

final class ProviderLink implements Link
{

	/** @var Router */
	private $router;

	/** @var string */
	private $mask;

	/** @var array */
	private $args;

	/** @var array */
	private $options;

	/** @var LinkProviding */
	private $provider;

	/**
	 * @param Router $router
	 * @param string $mask
	 * @param array $args
	 * @param array $options
	 * @param LinkProviding $provider
	 */
	public function __construct(Router $router, $mask, array $args = [], array $options = [], LinkProviding $provider)
	{
		$this->router = $router;
		$this->mask = $mask;
		$this->args = $args;
		$this->options = $options;
		$this->provider = $provider;
	}

	/**
	 * @return string
	 */
	public function getMask()
	{
		return $this->mask;
	}

	/**
	 * @return array
	 */
	public function getArgs()
	{
		return $this->args;
	}

	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}

	/**
	 * @return LinkProviding
	 */
	public function getProvider()
	{
		return $this->provider;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->router->construct($this->provider->link($this), $this->options);
	}

}
