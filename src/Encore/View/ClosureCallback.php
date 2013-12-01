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
        return $this->getClosure()();
    }
    
    protected function getClosure()
    {
        return $this->closure;
    }
}
