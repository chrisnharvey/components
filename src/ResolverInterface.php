<?php

namespace Encore\Namespacer;

interface ResolverInterface
{
    public function parseKey($key);

    public function resolveKey($key, array $array, $default = null);
}