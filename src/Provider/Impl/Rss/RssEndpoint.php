<?php

namespace Blogette\Provider\Impl\Rss;

use Blogette\Exception\Logical\InvalidStateException;

final class RssEndpoint
{

	/** @var string */
	private $pattern;

	/** @var string */
	private $file;

	/** @var array */
	private $configuration;

	/**
	 * @param string $pattern
	 * @param string $file
	 * @param array $configuration
	 */
	public function __construct($pattern, $file, array $configuration)
	{
		$this->pattern = $pattern;
		$this->file = $file;
		$this->configuration = $configuration;
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

	/**
	 * @return array
	 */
	public function getConfiguration()
	{
		return $this->configuration;
	}

	/**
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function getAttribute($key, $default = NULL)
	{
		if (!$this->hasAttribute($key)) {
			if (func_num_args() < 2) {
				throw new InvalidStateException(sprintf('Configuration %s is missing', $key));
			}

			return $default;
		}

		return $this->configuration[$key];
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function hasAttribute($key)
	{
		return array_key_exists($key, $this->configuration);
	}

}
