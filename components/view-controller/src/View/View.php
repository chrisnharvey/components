<?php

namespace Encore\View;

use Encore\Controller\Controller;
use Encore\Controller\ControllerAwareTrait;
use Encore\Controller\ControllerAwareInterface;
use Encore\View\Style\StyleAwareInterface;
use Encore\View\Parser\Style\ParserInterface as StyleParserInterface;
use Encore\View\Parser\View\ParserInterface as ViewParserInterface;

class View implements ControllerAwareInterface
{
    use ControllerAwareTrait;

    protected $view;
    protected $viewPath;
    protected $stylePath;
    protected $viewParser;
    protected $styleParser;
    protected $parser;

    /**
     * Inject dependencies
     * 
     * @param ViewParserInterface  $viewParser
     * @param string               $viewPath
     * @param StyleParserInterface $styleParser
     * @param string               $stylePath
     */
    public function __construct(ViewParserInterface $viewParser, $viewPath, StyleParserInterface $styleParser = null, $stylePath = null)
    {
        $this->viewParser = $viewParser;
        $this->viewPath = $viewPath;
        $this->styleParser = $styleParser;
        $this->stylePath = $stylePath;
    }

    /**
     * Get an element by ID
     * 
     * @param  string $id
     * @return mixed
     */
    public function getElementById($id)
    {
        $this->parse();

        return $this->view->getElementById($id);
    }

    /**
     * Magic method to get element by ID.
     * 
     * @param  string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->getElementById($property);
    }

    /**
     * Set element value
     * 
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
        if ($element = $this->getElementById($property)) {
            return $element->setValue($value);
        }

        $this->$property = $value;
    }

    /**
     * Parse a view by path
     * 
     * @param  string $path
     * @return \Encore\View\Style\StyleCollection
     */
    public function parse()
    {
        if (isset($this->view)) return;

        if ($this->viewParser instanceof StyleAwareInterface
            and $this->styleParser) {

            $style = $this->styleParser->parse($this->stylePath);

            if ($style) $this->viewParser->setStyle($style);
        }

        $view = $this->viewParser->parse($this->viewPath);

        if ($view instanceof ControllerAwareInterface) {
            $view->setController($this->controller);
        }

        $this->view = $view;
    }
}