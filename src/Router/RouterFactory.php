<?php

namespace Blogette\Router;

use Blogette\Provider\ProviderCollection;

final class RouterFactory
{

    /** @var ProviderCollection */
    private $providers;

    /** @var array */
    private $configuration = [];

    /**
     * @param ProviderCollection $providers
     */
    public function __construct(ProviderCollection $providers)
    {
        $this->providers = $providers;
    }

    /**
     * @param array $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return Router
     */
    public function create()
    {
        $router = new SimpleRouter($this->providers);

        if (isset($this->configuration['base'])) {
            $router->setBase($this->configuration['base']);
        }

        if (isset($this->configuration['host'])) {
            $router->setHost($this->configuration['host']);
        }

        return $router;
    }

}
