<?php

namespace Blogette\Provider\Providing;

use Blogette\Template\Compiler;
use Blogette\Template\Template;

interface CompileProviding
{

    /**
     * @param Compiler $compiler
     * @return Template
     */
    public function compile(Compiler $compiler);

}
