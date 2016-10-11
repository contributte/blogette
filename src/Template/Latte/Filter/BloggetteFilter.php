<?php

namespace Blogette\Template\Latte\Filter;

use Latte\Engine;

final class BloggetteFilter implements Filter
{

    // Pattern
    const PATTERN = '#\{([\w\d\_\-]+)\}#';


    /** @var array */
    private $params;

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * @param string $s
     * @return string
     */
    public function process($s)
    {
        return preg_replace_callback(self::PATTERN, function ($matches) {
            if (count($matches) > 2) {
                throw new \RuntimeException('Invalid pattern, only one group is allowed');
            }

            list ($whole, $placeholder) = $matches;

            if (isset($this->params[$placeholder])) {
                return $this->params[$placeholder];
            }

            return $whole;
        }, $s);
    }

    /**
     * @param Engine $latte
     * @return void
     */
    public function register(Engine $latte)
    {
        $latte->addFilter('bloggette', [$this, 'process']);
    }

}
