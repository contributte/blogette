<?php

namespace Blogette\Provider\Visiting;

use Blogette\Provider\Providing\DumpProviding;
use Blogette\Template\Template;

interface DumpableVisiting
{

    /**
     * @param Template $template
     * @param DumpProviding $providing
     * @return void
     */
    public function dump(Template $template, DumpProviding $providing);

}
