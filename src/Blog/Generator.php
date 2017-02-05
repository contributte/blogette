<?php

namespace Blogette\Blog;

interface Generator
{

	/**
	 * Iterate over all providers and generate content
	 *
	 * @return void
	 */
	public function generate();

}
