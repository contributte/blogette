<?php

namespace Blogette\Blog;

use Blogette\Provider\ProviderCollection;
use Blogette\Provider\ProviderVisitor;

final class BlogetteGenerator
{

	/** @var ProviderCollection */
	private $providers;

	/** @var ProviderVisitor */
	private $visitor;

	/**
	 * @param ProviderCollection $providers
	 * @param ProviderVisitor $visitor
	 */
	public function __construct(ProviderCollection $providers, ProviderVisitor $visitor)
	{
		$this->providers = $providers;
		$this->visitor = $visitor;
	}

	public function generate()
	{
		foreach ($this->providers->getAll() as $provider) {
			// Walk through the providers..
			$provider->provide($this->visitor);
		}
	}
}
