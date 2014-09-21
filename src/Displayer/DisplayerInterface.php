<?php

namespace Encore\Error\Displayer;

interface DisplayerInterface
{
    /**
     * Display the given exception to the user.
     *
     * @param  \Exception  $exception
     */
    public function display(\Exception $exception);
}