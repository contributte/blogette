<?php

namespace Blogette\Provider;

use Blogette\Provider\Providing\LinkProviding;
use Blogette\Router\Link\Link;
use Blogette\Router\Link\RouterLink;

final class CrossProviderLink implements LinkProviding
{

    /** @var string */
    private $mask;

    /** @var array */
    private $args;

    /** @var array */
    private $options;

    /**
     * @param string $mask
     * @param array $args
     * @param array $options
     */
    public function __construct($mask, array $args = [], array $options = [])
    {
        $this->mask = $mask;
        $this->args = $args;
        $this->options = $options;
    }

    /**
     * @param Link $link
     * @return Link
     */
    public function link(Link $link)
    {
        if ($link instanceof RouterLink) {
            return $link->getRouter()->link($this->mask, $this->args, $this->options);
        }

        return $link;
    }

}
