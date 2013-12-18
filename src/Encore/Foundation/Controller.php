<?php

namespace Encore\Foundation;

abstract class Controller
{
    public $data = array();

    public function __set($property, $value)
    {
        $this->data[$property] = $value;
    }

    public function __get($property)
    {
        return $this->data[$property];
    }

    public function __destruct()
    {
        $collection = \App::make('collection');
        $collection[] = $this->data;
    }
}