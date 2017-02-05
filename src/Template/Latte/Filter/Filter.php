<?php

namespace Blogette\Template\Latte\Filter;

use Latte\Engine;

interface Filter
{

	/**
	 * @param Engine $latte
	 * @return void
	 */
	public function register(Engine $latte);

}
