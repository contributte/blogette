<?php

namespace Blogette\Provider\Impl\Sitemap;

use Blogette\Post\PostCollection;
use Blogette\Provider\Impl\Sitemap\Model\SitemapModel;
use Blogette\Provider\ProviderVisitor;
use Blogette\Provider\UnifiedProvider;
use Blogette\Router\Link\Link;
use Blogette\Router\Link\ProviderLink;
use Blogette\Router\SimpleLinker;
use Blogette\Template\Compiler;
use Blogette\Template\Dumper;
use Blogette\Template\Template;

final class SitemapProvider extends UnifiedProvider
{

	/** @var SitemapEndpoint */
	private $endpoint;

	/** @var PostCollection */
	private $posts;

	/**
	 * @param SitemapEndpoint $endpoint
	 * @param PostCollection $posts
	 */
	public function __construct(SitemapEndpoint $endpoint, PostCollection $posts)
	{
		$this->endpoint = $endpoint;
		$this->posts = $posts;
	}

	/**
	 * @param ProviderVisitor $visitor
	 * @return void
	 */
	public function provide(ProviderVisitor $visitor)
	{
		$template = $visitor->compile($this);
		$visitor->dump($template, $this);
	}

	/**
	 * @param Compiler $compiler
	 * @return Template
	 */
	public function compile(Compiler $compiler)
	{
		$model = new SitemapModel($this->posts->getAll());

		$template = $compiler->compile(
			$this->endpoint->getFile(),
			(array) $model->create()
		);

		return $template;
	}

	/**
	 * @param Template $template
	 * @param Dumper $dumper
	 * @return void
	 */
	public function dump(Template $template, Dumper $dumper)
	{
		// Generate HTML page
		$linker = new SimpleLinker($this->endpoint->getPattern(), []);
		$dumper->dump($linker, $template);
	}

	/**
	 * @param Link|ProviderLink $link
	 * @return string
	 */
	public function link(Link $link)
	{
		return $this->endpoint->getPattern();
	}

}
