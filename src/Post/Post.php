<?php

namespace Blogette\Post;

use Nette\Utils\DateTime;

final class Post
{

	/** @var int */
	public $id;

	/** @var DateTime */
	public $date;

	/** @var string */
	public $title;

	/** @var array */
	public $seo;

	/** @var array */
	public $tags;

	/** @var string */
	public $perex;

	/** @var string */
	public $content;

}
