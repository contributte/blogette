<?php

namespace Blogette\Provider\Visiting;

use Blogette\Provider\Providing\CompileProviding;
use Blogette\Template\Template;

interface CompilableVisiting
{

    /**
     * @param CompileProviding $providing
     * @return Template
     */
    public function compile(CompileProviding $providing);

}
