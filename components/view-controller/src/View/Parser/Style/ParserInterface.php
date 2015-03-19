<?php

namespace Encore\View\Parser\Style;

interface ParserInterface
{
    /**
     * Parse a style by path
     * 
     * @param  string $path
     * @return \Encore\View\Style\StyleCollection
     */
    public function parse($path);
}