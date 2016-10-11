<?php

namespace Blogette\Provider\Impl\Page;

use Blogette\Post\PostCollection;
use Blogette\Provider\ProviderVisitor;
use Blogette\Provider\UnifiedProvider;
use Blogette\Router\Link\Link;
use Blogette\Router\Link\ProviderLink;
use Blogette\Router\SimpleLinker;
use Blogette\Template\Compiler;
use Blogette\Template\Dumper;
use Blogette\Template\Template;

final class StaticPageProvider extends UnifiedProvider
{

    /** @var PageEndpoint */
    private $endpoint;

    /** @var PostCollection */
    private $posts;

    /**
     * @param PageEndpoint $endpoint
     * @param PostCollection $posts
     */
    public function __construct(PageEndpoint $endpoint, PostCollection $posts)
    {
        $this->endpoint = $endpoint;
        $this->posts = $posts;
    }

    /**
     * @param ProviderVisitor $visitor
     */
    public function provide(ProviderVisitor $visitor)
    {
        $template = $visitor->compile($this);
        $visitor->dump($template, $this);
    }

    /**
     * @param Compiler $compiler
     * @return Template
     */
    public function compile(Compiler $compiler)
    {
        $file = $this->endpoint->getFile();
        $template = $compiler->compile(
            $file,
            ['posts' => $this->posts->getAll()]
        );

        return $template;
    }

    /**
     * @param Template $template
     * @param Dumper $dumper
     * @return void
     */
    public function dump(Template $template, Dumper $dumper)
    {
        // Generate HTML page
        $linker = new SimpleLinker($this->endpoint->getPattern(), []);
        $dumper->dump($linker, $template);
    }

    /**
     * @param ProviderLink|Link $link
     * @return string
     */
    public function link(Link $link)
    {
        return $this->endpoint->getPattern();
    }

}
