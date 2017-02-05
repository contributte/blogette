<?php
namespace Blogette\Template;

use Blogette\Provider\Providing\CompileProviding;
use Blogette\Provider\Providing\DumpProviding;

interface Generator
{

	/**
	 * @param CompileProviding $providing
	 * @return Template
	 */
	public function compile(CompileProviding $providing);


	/**
	 * @param Template $template
	 * @param DumpProviding $providing
	 * @return void
	 */
	public function dump(Template $template, DumpProviding $providing);

}
