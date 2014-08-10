<?php

namespace Encore\Error;

interface ExceptionDisplayerInterface
{
    /**
     * Display the given exception to the user.
     *
     * @param  \Exception  $exception
     */
    public function display(\Exception $exception);
}