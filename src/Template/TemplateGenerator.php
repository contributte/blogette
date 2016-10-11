<?php
namespace Blogette\Template;

use Blogette\Provider\Providing\CompileProviding;
use Blogette\Provider\Providing\DumpProviding;

final class TemplateGenerator implements Generator
{

    /** @var Compiler */
    private $compiler;

    /** @var Dumper */
    private $dumper;

    /**
     * @param Compiler $compiler
     * @param Dumper $dumper
     */
    public function __construct(Compiler $compiler, Dumper $dumper)
    {
        $this->compiler = $compiler;
        $this->dumper = $dumper;
    }

    /**
     * @param CompileProviding $providing
     * @return Template
     */
    public function compile(CompileProviding $providing)
    {
        return $providing->compile($this->compiler);
    }

    /**
     * @param Template $template
     * @param DumpProviding $providing
     * @return void
     */
    public function dump(Template $template, DumpProviding $providing)
    {
        $providing->dump($template, $this->dumper);
    }
}
