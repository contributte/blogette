<?php

namespace Blogette\Router\Link;

use Blogette\Router\Router;

final class RouterLink implements Link
{

    /** @var Router */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        throw new \RuntimeException();
    }

}
