<?php

namespace Blogette\Provider;

interface ProviderFactory
{

    /**
     * @return Provider
     */
    public function create();

}
