<?php

namespace Encore\View;

use Closure;

class ClosureCallback
{
    protected $closure;

    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function call()
    {
        return call_user_func($this->closure);
    }
}