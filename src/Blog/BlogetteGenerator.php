<?php

namespace Blogette\Blog;

use Blogette\Provider\ProviderCollection;
use Blogette\Provider\ProviderVisitor;

final class BlogetteGenerator implements Generator
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

	/**
	 * Iterate over all providers and generate content
	 *
	 * @return void
	 */
	public function generate()
	{
		foreach ($this->providers->getAll() as $provider) {
			// Walk through the providers..
			$provider->provide($this->visitor);
		}
	}

}
