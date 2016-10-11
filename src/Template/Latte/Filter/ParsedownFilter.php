<?php

namespace Blogette\Template\Latte\Filter;

use Latte\Engine;
use Minetro\Parsedown\ParsedownExtraAdapter;

final class ParsedownFilter implements Filter
{

    /**
     * @param Engine $latte
     * @return void
     */
    public function register(Engine $latte)
    {
        $parsedown = new ParsedownExtraAdapter();
        $latte->addFilter('parsedown', [$parsedown, 'process']);
    }

}
