<?php

namespace Encore\Giml;

interface ElementFactoryInterface
{
    /**
     * Make an element
     * 
     * @param  string $element
     * @throws InvalidElementException
     * @return ElementInterface
     */
    public function make($element);
}