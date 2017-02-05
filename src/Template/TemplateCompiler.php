<?php
namespace Blogette\Template;

use Blogette\Router\Link\Link;
use Blogette\Router\Router;
use Blogette\Router\RouterFactory;

final class TemplateCompiler implements Compiler
{

	/** @var TemplateEngineAdapter */
	private $adapter;

	/** @var RouterFactory */
	private $routerFactory;

	/** @var Router */
	private $router;

	/**
	 * @param TemplateEngineAdapter $adapter
	 * @param RouterFactory $routerFactory
	 */
	public function __construct(TemplateEngineAdapter $adapter, RouterFactory $routerFactory)
	{
		$this->adapter = $adapter;
		$this->routerFactory = $routerFactory;
	}

	/**
	 * @param string $file
	 * @param array $params
	 * @return Template
	 */
	public function compile($file, array $params = [])
	{
		$router = $this->getRouter();

		// Prepare params
		$params = array_merge([
			'base' => $router->getBase(),
			'host' => $router->getHost(),
			'revision' => (object) [
				'hash' => substr(md5(time()), 0, 10),
				'timestamp' => time(),
				'date' => date('dmY'),
			],
			'router' => $router,
		], $params);

		// Creates template
		$template = $this->adapter->create($file, $params);

		return $template;
	}

	/**
	 * @param string $mask
	 * @param array $args
	 * @param array $options
	 * @return Link
	 */
	public function link($mask, array $args = [], array $options = [])
	{
		return $this->getRouter()->link($mask, $args, $options);
	}

	/**
	 * HELPERS *****************************************************************
	 */

	/**
	 * @return Router
	 */
	private function getRouter()
	{
		if (!$this->router) {
			$this->router = $this->routerFactory->create();
		}

		return $this->router;
	}

}
