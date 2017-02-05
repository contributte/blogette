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
	private $templateGenerator;

	/** @var Router */
	private $router;

	/**
	 * @param TemplateGenerator $templateGenerator
	 * @param Router $router
	 */
	public function __construct(TemplateGenerator $templateGenerator, Router $router)
	{
		$this->templateGenerator = $templateGenerator;
		$this->router = $router;
	}

	/**
	 * @param CompileProviding $providing
	 * @return Template
	 */
	public function compile(CompileProviding $providing)
	{
		return $this->templateGenerator->compile($providing);
	}

	/**
	 * @param Template $template
	 * @param DumpProviding $providing
	 * @return void
	 */
	public function dump(Template $template, DumpProviding $providing)
	{
		$this->templateGenerator->dump($template, $providing);
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
