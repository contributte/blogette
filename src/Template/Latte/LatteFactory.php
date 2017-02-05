<?php

namespace Blogette\Template\Latte;

use Latte\Engine;

final class LatteFactory
{

	/**
	 * @return Engine
	 */
	public function create()
	{
		$latte = new Engine();
		$latte->setContentType(Engine::CONTENT_HTML);

		return $latte;
	}

}
