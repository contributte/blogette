<?php
namespace Blogette\Template;

use Blogette\Router\Linker;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;

final class TemplateDumper implements Dumper
{

	/** @var string */
	private $buildDir;

	/**
	 * @param string $buildDir
	 */
	public function __construct($buildDir)
	{
		$this->buildDir = $buildDir;
	}

	/**
	 * @param Linker $linker
	 * @param Template $template
	 * @return void
	 */
	public function dump(Linker $linker, Template $template)
	{
		$link = $linker->build();

		$filename = $this->buildDir . '/' . $link;

		// Replace multiple slashes with single one
		$filename = Strings::replace($filename, '#/{2,}#', '/');

		FileSystem::createDir(dirname($filename));
		FileSystem::write($filename, $template->render());
	}

}
