<?php

namespace Blogette\Provider;

abstract class AbstractProviderFactory implements ProviderFactory
{

	/** @var string */
	protected $pattern;

	/** @var string */
	protected $file;

	/** @var array */
	protected $configuration = [];

	/**
	 * @return string
	 */
	public function getPattern()
	{
		return $this->pattern;
	}

	/**
	 * @param string $pattern
	 * @return void
	 */
	public function setPattern($pattern)
	{
		$this->pattern = $pattern;
	}

	/**
	 * @return string
	 */
	public function getFile()
	{
		return $this->file;
	}

	/**
	 * @param string $file
	 * @return void
	 */
	public function setFile($file)
	{
		$this->file = $file;
	}

	/**
	 * @return array
	 */
	public function getConfiguration()
	{
		return $this->configuration;
	}

	/**
	 * @param array $configuration
	 * @return void
	 */
	public function setConfiguration(array $configuration)
	{
		$this->configuration = $configuration;
	}

}
