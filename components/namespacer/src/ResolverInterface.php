<?php

namespace Encore\Namespacer;

interface ResolverInterface
{
    /**
     * Parse a key into namespace, group, and item.
     *
     * @param string $key
     * @return array
     */
    public function parseKey($key);

    /**
     * Resolve a namespace key from an array
     * 
     * @param  string $key
     * @param  array  $array
     * @param  mixed $default
     * @return mixed
     */
    public function resolveKey($key, array $array, $default = null);
}