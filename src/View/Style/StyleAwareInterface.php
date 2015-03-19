<?php

namespace Encore\View\Style;

interface StyleAwareInterface
{
    /**
     * Set the style collection
     * 
     * @param StyleCollection $style
     */
    public function setStyle(StyleCollection $style);
}