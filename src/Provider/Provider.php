<?php

namespace Blogette\Provider;

interface Provider
{

    /**
     * @param ProviderVisitor $visitor
     * @return void
     */
    public function provide(ProviderVisitor $visitor);

}
