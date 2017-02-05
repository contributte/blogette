<?php

namespace Blogette\Provider\Impl\Post;

final class PostEndpoint
{

	/** @var string */
	private $pattern;

	/** @var string */
	private $file;

	/**
	 * @param string $pattern
	 * @param string $file
	 */
	public function __construct($pattern, $file)
	{
		$this->pattern = $pattern;
		$this->file = $file;
	}

	/**
	 * @return string
	 */
	public function getPattern()
	{
		return $this->pattern;
	}

	/**
	 * @return string
	 */
	public function getFile()
	{
		return $this->file;
	}

}
