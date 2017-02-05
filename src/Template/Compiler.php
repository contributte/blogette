<?php

namespace Blogette\Template;

interface Compiler
{

	/**
	 * @param string $file
	 * @param array $params
	 * @return Template
	 */
	public function compile($file, array $params = []);

	/**
	 * @param string $mask
	 * @param array $args
	 * @param array $options
	 * @return string
	 */
	public function link($mask, array $args = [], array $options = []);

}
