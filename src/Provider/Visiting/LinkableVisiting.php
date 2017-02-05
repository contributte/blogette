<?php

namespace Blogette\Provider\Visiting;

use Blogette\Provider\Providing\LinkProviding;

interface LinkableVisiting
{

	/**
	 * @param LinkProviding $providing
	 * @return string
	 */
	public function link(LinkProviding $providing);

}
