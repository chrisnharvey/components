<?php

namespace Encore\View;

class Manager
{
    public function __construct(FinderInterface $finder)
    {
        $this->finder = $finder;
    }

    public function make($view)
    {
        $path = $this->finder->find($view);

        return new View($path);
    }
}