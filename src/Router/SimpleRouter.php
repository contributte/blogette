<?php

namespace Blogette\Router;

use Blogette\Provider\ProviderCollection;
use Blogette\Provider\Providing\LinkProviding;
use Blogette\Router\Link\Link;
use Blogette\Router\Link\ProviderLink;
use Blogette\Router\Link\SelfLink;
use Nette\Utils\Strings;

final class SimpleRouter implements Router
{

	/** @var ProviderCollection */
	private $providers;

	/** @var string */
	private $base;

	/** @var string */
	private $host;

	/**
	 * @param ProviderCollection $providers
	 */
	public function __construct(ProviderCollection $providers)
	{
		$this->providers = $providers;
	}

	/**
	 * @return string
	 */
	public function getBase()
	{
		return $this->base;
	}

	/**
	 * @param string $base
	 * @return void
	 */
	public function setBase($base)
	{
		$this->base = trim($base, '/');
	}

	/**
	 * @return string
	 */
	public function getHost()
	{
		return $this->host;
	}

	/**
	 * @param string $host
	 * @return void
	 */
	public function setHost($host)
	{
		$this->host = trim($host, '/');
	}

	/**
	 * @param string $mask
	 * @param array $args
	 * @param array $options
	 * @return Link
	 */
	public function link($mask, array $args = [], array $options = [])
	{
		if ($mask === self::SELF) {
			return new SelfLink($this, $options);
		}

		$provider = $this->providers->get($mask);
		if (!$provider) {
			throw new \RuntimeException('No provider for link found:' . $mask);
		}

		if (!($provider instanceof LinkProviding)) {
			throw new \RuntimeException('Invalid interface...' . $mask);
		}

		return new ProviderLink($this, $mask, $args, $options, $provider);
	}

	/**
	 * @param string $uri
	 * @param array $options
	 * @return string
	 */
	public function construct($uri, array $options = [])
	{
		$url = '';

		// Append host
		if (isset($options[Router::ABSOLUTE]) && $options[Router::ABSOLUTE] === TRUE) {
			$url = $this->host;
		}

		// Append base url
		if ($this->base) {
			$url .= '/' . $this->base;
		}

		// Append uri
		$url .= sprintf('/%s', ltrim($uri, '/'));

		// Drop index.html, it's not necessary
		$url = Strings::replace($url, '#(.+)index.html$#', '$1');

		return $url;
	}

}
