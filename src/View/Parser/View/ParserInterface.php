<?php

namespace Encore\View\Parser\View;

interface ParserInterface
{
    /**
     * Parse a view by path
     * 
     * @param  string $path
     * @return array
     */
    public function parse($path);
}