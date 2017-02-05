<?php

namespace Blogette\Provider\Impl\Sitemap;

use Blogette\Post\PostCollection;
use Blogette\Provider\AbstractProviderFactory;

final class SitemapProviderFactory extends AbstractProviderFactory
{

	/** @var PostCollection */
	private $posts;

	/**
	 * @param PostCollection $posts
	 */
	public function __construct(PostCollection $posts)
	{
		$this->posts = $posts;
	}

	/**
	 * @return SitemapProvider
	 */
	public function create()
	{
		return new SitemapProvider(new SitemapEndpoint($this->pattern, $this->file), $this->posts);
	}
}
