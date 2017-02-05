<?php

namespace Blogette\Provider\Impl\Sitemap\Model;

use Blogette\Post\Post;
use Blogette\Router\Router;
use stdClass;

final class SitemapModel
{

	// Change frequency
	const FREQ_ALWAYS = 'always';
	const FREQ_HOURLY = 'hourly';
	const FREQ_DAILY = 'daily';
	const FREQ_WEEKLY = 'weekly';
	const FREQ_MONTHLY = 'monthly';
	const FREQ_YEARLY = 'yearly';
	const FREQ_NEVER = 'never';

	/** @var Post[] */
	private $posts;

	/**
	 * @param Post[] $posts
	 */
	public function __construct(array $posts)
	{
		$this->posts = $posts;
	}

	/**
	 * @return stdClass
	 */
	public function create()
	{
		$items = [];

		$items[] = (object) [
			'loc' => (object) [
				'name' => 'home',
				'args' => [],
				'options' => [Router::ABSOLUTE => TRUE],
			],
			'change' => self::FREQ_WEEKLY,
			'priority' => 1.0,
		];

		foreach ($this->posts as $post) {
			$items[] = (object) [
				'loc' => (object) [
					'name' => 'post',
					'args' => ['id' => $post->id],
					'options' => [Router::ABSOLUTE => TRUE],
				],
				'change' => self::FREQ_MONTHLY,
				'priority' => 0.9,
			];
		}

		return (object) [
			'items' => $items,
		];
	}

}
