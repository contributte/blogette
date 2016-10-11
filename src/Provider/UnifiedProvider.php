<?php

namespace Blogette\Provider;

use Blogette\Provider\Providing\CompileProviding;
use Blogette\Provider\Providing\DumpProviding;
use Blogette\Provider\Providing\LinkProviding;

abstract class UnifiedProvider implements Provider, CompileProviding, DumpProviding, LinkProviding
{

}
