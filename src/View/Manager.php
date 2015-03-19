<?php

namespace Encore\View;

use InvalidArgumentException;
use Encore\Resource\FinderInterface;
use Encore\Container\ContainerAwareTrait;
use Encore\Container\ContainerAwareInterface;
use Encore\View\Parser\Style\ParserInterface as StyleParserInterface;
use Encore\View\Parser\View\ParserInterface as ViewParserInterface;

class Manager implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Constructor
     * 
     * @param FinderInterface      $viewFinder
     * @param ViewParserInterface  $viewParser
     * @param FinderInterface      $styleFinder
     * @param StyleParserInterface $styleParser
     */
    public function __construct(FinderInterface $viewFinder, ViewParserInterface $viewParser, FinderInterface $styleFinder, StyleParserInterface $styleParser)
    {
        $this->viewFinder = $viewFinder;
        $this->styleFinder = $styleFinder;
        $this->viewParser = $viewParser;
        $this->styleParser = $styleParser;
    }

    /**
     * Make a view object
     * 
     * @param  string $view
     * @param  string $styl
     * @return View
     */
    public function make($view, $style = null)
    {
        $viewPath = $this->viewFinder->find($view);

        try {
            $stylePath = $this->styleFinder->find($style ?: $view);
        } catch (InvalidArgumentException $e) {
            $stylePath = null;
        }

        return new View($this->viewParser, $viewPath, $this->styleParser, $stylePath);
    }
}