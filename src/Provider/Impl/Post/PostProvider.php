<?php

namespace Blogette\Provider\Impl\Post;

use Blogette\Post\Post;
use Blogette\Post\PostCollection;
use Blogette\Provider\ProviderVisitor;
use Blogette\Provider\UnifiedProvider;
use Blogette\Router\Link\Link;
use Blogette\Router\Link\ProviderLink;
use Blogette\Router\SimpleLinker;
use Blogette\Template\Compiler;
use Blogette\Template\Dumper;
use Blogette\Template\Template;
use Nette\Utils\DateTime;
use Nette\Utils\Strings;

final class PostProvider extends UnifiedProvider
{

    /** @var PostEndpoint */
    private $endpoint;

    /** @var PostCollection */
    private $posts;

    /** @var Post */
    private $post;

    /**
     * @param PostEndpoint $endpoint
     * @param PostCollection $posts
     */
    public function __construct(PostEndpoint $endpoint, PostCollection $posts)
    {
        $this->endpoint = $endpoint;
        $this->posts = $posts;
    }

    /**
     * @param ProviderVisitor $visitor
     */
    public function provide(ProviderVisitor $visitor)
    {
        foreach ($this->posts->getAll() as $post) {
            // Set current post
            $this->post = $post;

            // Apply visitor
            $template = $visitor->compile($this);
            $visitor->dump($template, $this);
        }
    }

    /**
     * @param Compiler $compiler
     * @return Template
     */
    public function compile(Compiler $compiler)
    {
        $post = $this->getPost();

        // Compile template
        $template = $compiler->compile(
            $this->endpoint->getFile(),
            [
                'post' => $post,
                'prev' => $this->posts->getPreviousOne($post->id),
                'next' => $this->posts->getNextOne($post->id),
            ]
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
        $post = $this->getPost();
        $linker = $this->createLinker($post);

        // Generate HTML page
        $dumper->dump($linker, $template);
    }


    /**
     * @param Link|ProviderLink $link
     * @return string
     */
    public function link(Link $link)
    {
        $id = $link->getArgs()['id'];
        $post = $this->posts->getOne($id);
        $linker = $this->createLinker($post);

        return $linker->build();
    }

    /**
     * HELPERS *****************************************************************
     */

    /**
     * @param Post $post
     * @return SimpleLinker
     */
    private function createLinker(Post $post)
    {
        return new SimpleLinker($this->endpoint->getPattern(), [
            'id' => $post->id,
            'day' => DateTime::from($post->date)->format('d'),
            'month' => DateTime::from($post->date)->format('m'),
            'year' => DateTime::from($post->date)->format('Y'),
            'title' => Strings::webalize($post->title),
        ]);
    }

    /**
     * @return Post
     */
    private function getPost()
    {
        return $this->post;
    }

}
