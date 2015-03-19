<?php

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Resources')
    ->exclude('Tests')
    ->in('components/*/src')
    ->in('kernel/vendor/encorephp/*/src');

return new Sami($iterator, [
    'build_dir'            => (is_dir(__DIR__.'/site/output_prod') ? __DIR__.'/site/output_prod' : __DIR__.'/site/output_dev').'/api',
    'default_opened_level' => 2,
]);