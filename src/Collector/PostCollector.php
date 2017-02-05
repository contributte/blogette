<?php

namespace Blogette\Collector;

use Nette\Utils\Finder;
use SplFileInfo;

final class PostCollector implements Collector
{

	/** @var string */
	private $dir;

	/**
	 * @param string $dir
	 */
	public function __construct($dir)
	{
		$this->dir = $dir;
	}

	/**
	 * @return array
	 */
	public function collect()
	{
		$files = [];

		/** @var SplFileInfo $file */
		foreach (Finder::findFiles('*.meta')->from($this->dir) as $file) {
			$files[] = $file->getPathname();
		}

		return $files;
	}

}
