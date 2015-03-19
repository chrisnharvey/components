<?php

namespace Encore\Container\Test\Stub;

class Baz implements BazInterface
{
    public function noDependencies()
    {
        return true;
    }

    public function noTypeHint($arg = 'baz')
    {
        return $arg;
    }

    public function noTypeHintOrDefaultValue($arg)
    {
        return $arg;
    }
}
