<?php

namespace Blogette\Provider;

use Blogette\Provider\Visiting\CompilableVisiting;
use Blogette\Provider\Visiting\DumpableVisiting;
use Blogette\Provider\Visiting\LinkableVisiting;

interface ProviderVisitor extends CompilableVisiting, DumpableVisiting, LinkableVisiting
{


}
