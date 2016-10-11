<?php

namespace Blogette\Provider\Impl\Page;

use Blogette\Post\PostCollection;
use Blogette\Provider\AbstractProviderFactory;

final class StaticPageProviderFactory extends AbstractProviderFactory
{

    /** @var PostCollection */
    private $posts;

    /**
     * @param PostCollection $posts
     */
    public function __construct(PostCollection $posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return StaticPageProvider
     */
    public function create()
    {
        return new StaticPageProvider(new PageEndpoint($this->pattern, $this->file), $this->posts);
    }

}
