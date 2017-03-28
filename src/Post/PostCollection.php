<?php

namespace Blogette\Post;

final class PostCollection
{

	/** @var Post[] */
	private $posts = [];

	/**
	 * @param Post[] $posts
	 */
	public function __construct(array $posts)
	{
		$this->posts = $posts;
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->posts);
	}

	/**
	 * @param int $id
	 * @return Post|NULL
	 */
	public function getOne($id)
	{
		foreach ($this->posts as $post) {
			if ($post->id === $id) return $post;
		}

		return NULL;
	}

	/**
	 * @param int $id
	 * @return Post
	 */
	public function getNextOne($id)
	{
		$next = $this->getOne($id + 1);

		if ($next !== NULL) return $next;

		return $this->posts[count($this->posts) - 1];
	}

	/**
	 * @param int $id
	 * @return Post
	 */
	public function getPreviousOne($id)
	{
		$prev = $this->getOne($id - 1);

		if ($prev !== NULL) return $prev;

		return $this->posts[0];
	}

	/**
	 * @return Post[]
	 */
	public function getAll()
	{
		return $this->posts;
	}

}
