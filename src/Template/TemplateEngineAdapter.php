<?php

namespace Blogette\Template;

interface TemplateEngineAdapter
{

	/**
	 * @param string $file
	 * @param array $params
	 * @return Template
	 */
	public function create($file, array $params = []);

}
