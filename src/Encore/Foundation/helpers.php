<?php

function curdir()
{
    $trace = debug_backtrace(0, 1);

    return dirname($trace[0]['file']);
}