<?php

/**
 * Helper class to parse resource namespace strings.
 * Taken from illuminate/support
 */

namespace Encore\Namespacer;

abstract class Namespacable extends Resolver implements NamespacableInterface
{
    use NamespacableTrait;
}