<?php

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Resources')
    ->exclude('Tests')
    ->in('components/*/src');

return new Sami($iterator, [
    'build_dir'            => __DIR__.'/api',
    'default_opened_level' => 2,
]);
