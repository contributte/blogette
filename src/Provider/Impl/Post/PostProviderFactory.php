<?php

namespace Blogette\Provider\Impl\Post;

use Blogette\Post\PostCollection;
use Blogette\Provider\AbstractProviderFactory;

final class PostProviderFactory extends AbstractProviderFactory
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
	 * @return PostProvider
	 */
	public function create()
	{
		return new PostProvider(new PostEndpoint($this->pattern, $this->file), $this->posts);
	}

}
