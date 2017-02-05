<?php

namespace Blogette\Provider\Providing;

use Blogette\Router\Link\Link;

interface LinkProviding
{

	/**
	 * @param Link $link
	 * @return string
	 */
	public function link(Link $link);

}
