<?php

namespace Blogette\Provider;

final class ProviderCollection
{

	/** @var Provider[] */
	private $providers;

	/**
	 * @param Provider[] $providers
	 */
	public function __construct(array $providers)
	{
		$this->providers = $providers;
	}

	/**
	 * @param string $name
	 * @return Provider
	 */
	public function get($name)
	{
		if (!isset($this->providers[$name])) return NULL;

		return $this->providers[$name];
	}

	public function getAll()
	{
		return $this->providers;
	}


}
