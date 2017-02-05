<?php

namespace Blogette\Post;

use Blogette\Collector\PostCollector;
use Nette\DI\Config\Adapters\NeonAdapter;
use Nette\Utils\DateTime;
use Nette\Utils\Strings;

final class PostsFactory
{

	const HEADLINE = '\<\!\-\-\s*headline\s*\-\-\>';
	const PAGEBREAK = '\<\!\-\-\s*pagebreak\s*\-\-\>';

	/** @var PostCollector */
	private $collector;

	/**
	 * @param PostCollector $collector
	 */
	public function __construct(PostCollector $collector)
	{
		$this->collector = $collector;
	}

	/**
	 * @return PostCollection
	 */
	public function create()
	{
		/** @var Post[] $posts */
		$posts = [];

		// Collect files
		$files = $this->collector->collect();

		foreach ($files as $file) {
			// Skip if meta or content file is not found
			if (!file_exists($file)) continue;

			// Parse metadata
			$neon = new NeonAdapter();
			$metadata = $neon->load($file);
			$contentfile = dirname($file) . '/' . $metadata['file'];

			// Parse headline, perex and content
			$content = @file_get_contents($contentfile);
			$matches1 = Strings::match($content, "#(.*)" . self::HEADLINE . "(.*)#s");

			// Skip invalid content
			if (!$matches1) continue;

			$matches2 = Strings::match($matches1[2], "#(.*)" . self::PAGEBREAK . "(.*)#s");
			// Skip invalid content
			if (!$matches2) continue;

			// Create post
			$posts[$metadata['id']] = $post = new Post();
			$post->id = $metadata['id'];
			$post->date = new DateTime($metadata['date']);
			$post->title = trim($matches1[1], "#\s\r\n\t ");
			$post->seo = $metadata['seo'];
			$post->tags = $metadata['tags'];
			$post->perex = $matches2[1];
			$post->content = $matches2[2];
		}

		// Sort posts by date
		usort($posts, function (Post $a, Post $b) {
			return $a->date < $b->date;
		});

		return new PostCollection($posts);
	}

}
