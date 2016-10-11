<?php

namespace Blogette\Provider\Impl\Rss;

use Blogette\Post\PostCollection;
use Blogette\Provider\Impl\Rss\Model\RssModel;
use Blogette\Provider\ProviderVisitor;
use Blogette\Provider\UnifiedProvider;
use Blogette\Router\Link\Link;
use Blogette\Router\Link\ProviderLink;
use Blogette\Router\Router;
use Blogette\Router\SimpleLinker;
use Blogette\Template\Compiler;
use Blogette\Template\Dumper;
use Blogette\Template\Template;

final class RssProvider extends UnifiedProvider
{

    /** @var RssEndpoint */
    private $endpoint;

    /** @var PostCollection */
    private $posts;

    /**
     * @param RssEndpoint $endpoint
     * @param PostCollection $posts
     */
    public function __construct(RssEndpoint $endpoint, PostCollection $posts)
    {
        $this->endpoint = $endpoint;
        $this->posts = $posts;
    }

    /**
     * @param ProviderVisitor $visitor
     * @return void
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
        $model = new RssModel();

        // Prepare channel
        $model->setTitle('Felix DevBlog');
        $model->setLink($compiler->link('self', [], [Router::ABSOLUTE => TRUE]));
        $model->setDescription('Blog o programování a tak..');
        $model->setChannelProperty("lastBuildDate", time());
        $model->setChannelProperty("language", 'cs');

        // Find posts
        $posts = $this->posts->getAll();

        // Add posts to feed
        foreach ($posts as $post) {
            $model->addItem([
                'title' => $post->title,
                'link' => $compiler->link('post', ['id' => $post->id], [Router::ABSOLUTE => TRUE]),
                'description' => strip_tags($post->perex),
                'pubDate' => $post->date,
                'guid' => sprintf('%s@%s', $post->id, $compiler->link('post', ['id' => $post->id], [Router::ABSOLUTE => TRUE])),
            ]);
        }

        $template = $compiler->compile(
            $this->endpoint->getFile(),
            (array) $model->create()
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
     * @param Link|ProviderLink $link
     * @return string
     */
    public function link(Link $link)
    {
        return $this->endpoint->getPattern();
    }
}
