<?php

namespace Encore\Giml;

interface ReaderInterface
{
    public function open($path, $encoding = null, $options = null);

    public function parse();
}