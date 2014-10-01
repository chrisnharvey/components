<?php

namespace Encore\Giml;

interface ReaderInterface
{
    /**
     * Open a .gim file
     * 
     * @param  string $path
     * @param  string $encoding
     * @param  string $options
     * @return void
     */
    public function open($path, $encoding = null, $options = null);

    /**
     * Parse the file
     * 
     * @return array
     */
    public function parse();
}