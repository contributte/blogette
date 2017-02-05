<?php

namespace Blogette\Provider;

final class ProviderCollectionFactory
{

	/** @var ProviderFactory[] */
	private $factories = [];

	/**
	 * @param string $name
	 * @param ProviderFactory $factory
	 * @return void
	 */
	public function addProviderFactory($name, ProviderFactory $factory)
	{
		$this->factories[$name] = $factory;
	}

	/**
	 * @return ProviderCollection
	 */
	public function create()
	{
		$providers = [];

		foreach ($this->factories as $name => $factory) {
			$providers[$name] = $factory->create();
		}

		return new ProviderCollection($providers);
	}

}
