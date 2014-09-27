<?php

namespace Encore\View\Parser\View;

use Encore\Giml\Parser as GimlParser;
use Encore\Giml\ElementInterface;
use Encore\View\Style\StyleAwareInterface;
use Encore\View\Style\StyleCollection;
use Encore\View\Parser\Style\ParserInterface as StyleParserInterface;

class Giml extends GimlParser implements ParserInterface, StyleAwareInterface
{
    protected $style = null;

    /**
     * Parse view elements
     * 
     * @param  array  $elements
     * @param  ElementInterface $parent
     * @return array
     */
    public function parseElements(array $elements, ElementInterface $parent = null)
    {
        foreach ($elements as &$element) {
            $element = $this->applyStyles($element);
        }

        return parent::parseElements($elements, $parent);
    }

    /**
     * Set the style collection
     * 
     * @param StyleCollection $style
     */
    public function setStyle(StyleCollection $style)
    {
        $this->style = $style;
    }

    /**
     * Apply the styles to the element
     * 
     * @param  array $element
     * @return array
     */
    protected function applyStyles($element)
    {
        if ( ! $this->style) return;

        if (array_key_exists('class', $element['attributes'])) {
            $classes = explode(' ', $element['attributes']['class']);
            $element = $this->applyStylesToElement($element, $this->style->getByClasses($classes));
        }

        if (array_key_exists('id', $element['attributes'])) {
            $element = $this->applyStylesToElement($element, $this->style->getById($element['attributes']['id']));
        }

        $element = $this->applyStylesToElement($element, $this->style->getByElement($element['name']));

        return $element;
    }

    /**
     * Apply styles to the attributes tag
     * 
     * @param  array $element
     * @param  array $styles
     * @return array
     */
    protected function applyStylesToElement($element, $styles)
    {
        foreach ($styles as $tag => $data) {
            $element['attributes'][$tag] = $data;
        }

        return $element;
    }
}