<?php

namespace Blogette\Router;

use Blogette\Provider\ProviderCollection;
use Blogette\Provider\Providing\LinkProviding;
use Blogette\Router\Link\Link;
use Blogette\Router\Link\ProviderLink;
use Blogette\Router\Link\SelfLink;
use Nette\Http\Url;
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
		$this->base = ltrim($base, '/');
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
		$this->host = rtrim($host, '/');
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
		$url = new Url();

		// Setup host ============================
		if (isset($options[Router::ABSOLUTE]) && $options[Router::ABSOLUTE] === TRUE) {
			$host = new Url($this->getHost());
			$url->setScheme($host->getScheme());
			$url->setHost($host->getHost());
		}

		// Setup path ============================
		if ($this->base) {
			$uri .= $this->getBase() . '/' . $uri;
		}

		// Drop index.html, it's not necessary
		$uri = Strings::replace($uri, '#(.+)index.html$#', '$1');

		// Set path
		$url->setPath($uri);

		return (string) $url;
	}

}
