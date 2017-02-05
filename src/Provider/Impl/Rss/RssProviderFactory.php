<?php

namespace Blogette\Provider\Impl\Rss;

use Blogette\Post\PostCollection;
use Blogette\Provider\AbstractProviderFactory;

final class RssProviderFactory extends AbstractProviderFactory
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
	 * @return RssProvider
	 */
	public function create()
	{
		return new RssProvider(new RssEndpoint($this->pattern, $this->file, $this->configuration), $this->posts);
	}

}
