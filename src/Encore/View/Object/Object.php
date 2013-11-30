<?php

namespace Encore\View\Object;

class Object
{
    protected $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function __call($method, $args)
    {
        // Convert camel case into pascal case
        $pascalMethod = ucfirst($method);

        if (method_exists($this->object, $pascalMethod)) {
            return call_user_func_array(array($this->object, $pascalMethod), $args);
        }

        throw new \RuntimeException("Method '{$method}' does not exist");
    }
}