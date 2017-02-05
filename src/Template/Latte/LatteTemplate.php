<?php

namespace Blogette\Template\Latte;

use Blogette\Template\Template;
use Latte\Engine;

final class LatteTemplate implements Template
{

	/** @var Engine */
	private $latte;


	/** @var string */
	private $file;

	/** @var array */
	private $parameters = [];

	/**
	 * @param Engine $latte
	 */
	public function __construct(Engine $latte)
	{
		$this->latte = $latte;
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
	 */
	public function setFile($file)
	{
		$this->file = $file;
	}

	/**
	 * @return array
	 */
	public function getParameters()
	{
		return $this->parameters;
	}

	/**
	 * @param array $parameters
	 */
	public function setParameters($parameters)
	{
		$this->parameters = $parameters;
	}

	/**
	 * @return string
	 */
	public function render()
	{
		return $this->latte->renderToString($this->file, $this->parameters);
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}

}
