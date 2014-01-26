<?php

/**
 * Helper class to parse resource namespace strings.
 * Taken from illuminate/support
 */

namespace Encore\Namespacer;

interface NamespacableInterface
{
    /**
     * Add a namespace and provide a hint
     *
     * @param string $namespace
     * @param string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint);
}