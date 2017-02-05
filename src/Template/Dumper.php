<?php
namespace Blogette\Template;

use Blogette\Router\Linker;

interface Dumper
{

	/**
	 * @param Linker $linker
	 * @param Template $template
	 * @return void
	 */
	public function dump(Linker $linker, Template $template);

}
