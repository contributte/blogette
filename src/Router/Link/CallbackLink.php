<?php

namespace Blogette\Router\Link;

final class CallbackLink implements Link
{

    /** @var callable */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return call_user_func($this->callback, $this);
    }

}
