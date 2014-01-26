<?php

/**
 * Helper class to parse resource namespace strings.
 * Taken from illuminate/support
 */

namespace Encore\Namespacer;

abstract class Namespacable
{
    /**
     * All of the namespace hints.
     *
     * @var array
     */
    protected $hints = [];

    /**
     * Add a namespace and provide a hint
     *
     * @param string $namespace
     * @param string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        $this->hints[$namespace] = $hint;
    }
}