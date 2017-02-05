<?php

namespace Blogette\Provider;

use Blogette\Provider\Providing\CompileProviding;
use Blogette\Provider\Providing\DumpProviding;
use Blogette\Provider\Providing\LinkProviding;
use Blogette\Router\Link\RouterLink;
use Blogette\Router\Router;
use Blogette\Template\Template;
use Blogette\Template\TemplateGenerator;

final class ProviderVisitorGenerator implements ProviderVisitor
{

	/** @var TemplateGenerator */
	private $templater;

	/** @var Router */
	private $router;

	/**
	 * @param TemplateGenerator $templater
	 * @param Router $router
	 */
	public function __construct(TemplateGenerator $templater, Router $router)
	{
		$this->templater = $templater;
		$this->router = $router;
	}

	/**
	 * @param CompileProviding $providing
	 * @return Template
	 */
	public function compile(CompileProviding $providing)
	{
		return $this->templater->compile($providing);
	}

	/**
	 * @param Template $template
	 * @param DumpProviding $providing
	 * @return void
	 */
	public function dump(Template $template, DumpProviding $providing)
	{
		$this->templater->dump($template, $providing);
	}

	/**
	 * @param LinkProviding $providing
	 * @return mixed
	 */
	public function link(LinkProviding $providing)
	{
		return $providing->link(new RouterLink($this->router));
	}
}
