<?php

namespace Blogette\Provider\Providing;

use Blogette\Template\Dumper;
use Blogette\Template\Template;

interface DumpProviding
{

    /**
     * @param Template $template
     * @param Dumper $dumper
     * @return void
     */
    public function dump(Template $template, Dumper $dumper);

}
