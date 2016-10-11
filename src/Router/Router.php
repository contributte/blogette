<?php

namespace Blogette\Router;

use Blogette\Router\Link\Link;

interface Router
{

    // Link aliases
    const SELF = 'self';

    // Options
    const ABSOLUTE = 'ABSOLUTE';

    /**
     * @return string
     */
    public function getBase();

    /**
     * @return string
     */
    public function getHost();

    /**
     * @param string $mask
     * @param array $args
     * @param array $options
     * @return Link
     */
    public function link($mask, array $args = [], array $options = []);

    /**
     * @param string $uri
     * @param array $options
     * @return string
     */
    public function construct($uri, array $options = []);

}
