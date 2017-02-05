<?php

namespace Blogette\Router;


final class SimpleLinker implements Linker
{

	// Pattern
	const PATTERN = '#\{([\w\d\_\-]+)\}#';

	/** @var string */
	private $pattern;

	/** @var array */
	private $map;

	/**
	 * @param string $pattern
	 * @param array $map
	 */
	public function __construct($pattern, array $map)
	{
		$this->pattern = $pattern;
		$this->map = $map;
	}


	/**
	 * @return string
	 */
	public function build()
	{
		return preg_replace_callback(self::PATTERN, function ($matches) {
			if (count($matches) > 2) {
				throw new \RuntimeException('Invalid pattern, only one group is allowed');
			}

			list ($whole, $param) = $matches;

			if (!isset($this->map[$param])) {
				bdump($this->map);
				throw new \RuntimeException('Invalid pattern, ..');
			}

			return $this->map[$param];
		}, $this->pattern);
	}


}
