<?php

namespace Encore\View\Parser\Style;

use Symfony\Component\Yaml\Parser as SymfonyYaml;
use Encore\View\Style\StyleCollection;

class Yaml implements ParserInterface
{
    public function __construct(SymfonyYaml $parser)
    {
        $this->parser = $parser;
    }

    public function parse($file)
    {
        if ( ! $file) return;

        $yaml = file_get_contents($file);

        $data = $this->parser->parse($yaml);

        $collection = new StyleCollection;

        foreach ($data as $key => $styles) {
            switch (substr($key, 0, 1)) {
                case '#':
                    $collection->addById(substr($key, 1), $styles);
                break;

                case '.':
                    $collection->addByClass(substr($key, 1), $styles);
                break;

                default:
                    $collection->addByElement($key, $styles);
                break;
            }
        }

        return $collection;

        // Convert into style type things that can detect styles for classes, ids and element names etc
    }
}