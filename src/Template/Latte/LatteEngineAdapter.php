<?php

namespace Blogette\Template\Latte;

use Blogette\Template\Latte\Filter\Filter;
use Blogette\Template\Template;
use Blogette\Template\TemplateEngineAdapter;

final class LatteEngineAdapter implements TemplateEngineAdapter
{

    /** @var LatteFactory */
    private $latteFactory;

    /** @var Filter[] */
    private $filters = [];

    /**
     * @param LatteFactory $latteFactory
     */
    public function __construct(LatteFactory $latteFactory)
    {
        $this->latteFactory = $latteFactory;
    }

    /**
     * @param Filter $filter
     */
    public function addFilter(Filter $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @param string $file
     * @param array $params
     * @return Template
     */
    public function create($file, array $params = [])
    {
        $latte = $this->latteFactory->create();

        foreach ($this->filters as $filter) {
            $filter->register($latte);
        }

        $template = new LatteTemplate($latte);
        $template->setFile($file);
        $template->setParameters($params);

        return $template;
    }

}
