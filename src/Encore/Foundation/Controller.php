<?php

namespace Encore\Foundation;

abstract class Controller
{
    public function __destruct()
    {
        $collection = \App::make('collection');
        $collection[] = get_object_vars($this);
    }
}