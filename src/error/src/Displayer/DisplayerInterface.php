<?php

namespace Encore\Error\Displayer;

use Exception;

interface DisplayerInterface
{
    /**
     * Display the given exception to the user.
     *
     * @param  Exception  $exception
     */
    public function display(Exception $exception);
}