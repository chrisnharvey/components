<?php

function curdir()
{
    $trace = debug_backtrace(0, 1);

    $dir = dirname($trace[0]['file']);

    $phar = \Phar::running(false);

    if (empty($phar)) return $dir;

    $dir = str_replace('phar://', '', $dir);

    $dir = str_replace($phar, '', $dir);
    $dir = str_replace(dirname($phar), '', $dir);

    return \Phar::running().$dir;
}