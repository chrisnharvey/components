<?php

namespace Encore\Error\Displayer;

class BasicDisplayer implements DisplayerInterface
{
    public function display(\Exception $exception)
    {
        echo PHP_EOL.$exception->getMessage().PHP_EOL;
    }
}