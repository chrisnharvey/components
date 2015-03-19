<?php

namespace Encore\Error\Displayer;

use Exception;

class BasicDisplayer implements DisplayerInterface
{
    /**
     * Display the exception the way PHP would normally
     * 
     * @param  Exception $exception
     * @return void
     */
    public function display(Exception $exception)
    {
        echo PHP_EOL.$exception->getMessage().PHP_EOL;
    }
}