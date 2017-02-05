<?php

namespace Blogette\DI;

use Blogette\Blog\BlogetteGenerator;
use Blogette\Collector\PostCollector;
use Blogette\Post\PostCollection;
use Blogette\Post\PostsFactory;
use Blogette\Provider\ProviderCollection;
use Blogette\Provider\ProviderCollectionFactory;
use Blogette\Provider\ProviderVisitorGenerator;
use Blogette\Router\RouterFactory;
use Blogette\Router\SimpleRouter;
use Blogette\Template\Latte\Filter\Filter;
use Blogette\Template\Latte\LatteEngineAdapter;
use Blogette\Template\Latte\LatteFactory;
use Blogette\Template\TemplateCompiler;
use Blogette\Template\TemplateDumper;
use Blogette\Template\TemplateGenerator;
use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;

final class BlogetteExtension extends CompilerExtension
{

	/** @var array */
	private $defaults = [
		'blog' => [
			'posts' => '%appDir/%templates%',
		],
		'router' => [
			'base' => NULL,
			'prefix' => NULL,
		],
		'build' => [
			'dir' => '%appDir/../build',
		],
		'endpoints' => [],
	];

	/**
	 * Register services
	 *
	 * @return void
	 */
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		$builder->addDefinition($this->prefix('generator'))
			->setClass(BlogetteGenerator::class);

		$builder->addDefinition($this->prefix('latte.factory'))
			->setClass(LatteFactory::class);

		$builder->addDefinition($this->prefix('router.factory'))
			->setClass(RouterFactory::class)
			->addSetup('setConfiguration', [$config['router']]);

		$builder->addDefinition($this->prefix('router'))
			->setClass(SimpleRouter::class)
			->setFactory('@' . $this->prefix('router.factory') . '::create');

		$builder->addDefinition($this->prefix('template.generator'))
			->setClass(TemplateGenerator::class);

		$builder->addDefinition($this->prefix('template.compiler'))
			->setClass(TemplateCompiler::class);

		$builder->addDefinition($this->prefix('template.dumper'))
			->setClass(TemplateDumper::class, [$config['build']['dir']]);

		$builder->addDefinition($this->prefix('template.adapter'))
			->setClass(LatteEngineAdapter::class);

		$builder->addDefinition($this->prefix('collector'))
			->setClass(PostCollector::class, [$config['blog']['posts']]);

		$builder->addDefinition($this->prefix('posts.factory'))
			->setClass(PostsFactory::class);

		$builder->addDefinition($this->prefix('posts'))
			->setClass(PostCollection::class)
			->setFactory('@' . $this->prefix('posts.factory') . '::create');

		$builder->addDefinition($this->prefix('provider.visitor'))
			->setClass(ProviderVisitorGenerator::class);

		$builder->addDefinition($this->prefix('providers.factory'))
			->setClass(ProviderCollectionFactory::class);

		$builder->addDefinition($this->prefix('providers'))
			->setClass(ProviderCollection::class)
			->setFactory('@' . $this->prefix('providers.factory') . '::create');

		foreach ($config['endpoints'] as $name => $provider) {
			$providerFactory = $this->prefix('providers.factory.' . $name);
			Compiler::loadDefinition($builder->addDefinition($providerFactory), $provider);

			$builder->getDefinition($this->prefix('providers.factory'))
				->addSetup('addProviderFactory', [$name, $builder->getDefinition($providerFactory)]);
		}
	}

	/**
	 * Decorate services
	 *
	 * @return void
	 */
	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();

		foreach ($builder->findByType(Filter::class) as $name => $def) {
			$builder->getDefinition($this->prefix('template.adapter'))
				->addSetup('addFilter', [$def]);
		}
	}

}
