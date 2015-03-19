<?php

namespace Encore\View\Style;

class StyleCollection
{
    protected $classes = [];
    protected $ids = [];
    protected $elements = [];

    /**
     * Add a style by class
     * 
     * @param string $class
     * @param array  $styles
     */
    public function addByClass($class, array $styles)
    {
        $this->classes[$class] = array_merge_recursive($this->getByClass($class), $styles);
    }

    /**
     * Get styles by class
     * 
     * @param  string $class
     * @return array
     */
    public function getByClass($class)
    {
        return array_key_exists($class, $this->classes)
            ? $this->classes[$class]
            : [];
    }

    /**
     * Add a style by ID
     * @param string $id
     * @param array  $styles [description]
     */
    public function addById($id, array $styles)
    {
        $this->ids[$id] = array_merge_recursive($this->getById($id), $styles);
    }

    /**
     * Get style by ID
     * 
     * @param  string $id
     * @return array
     */
    public function getById($id)
    {
        return array_key_exists($id, $this->ids)
            ? $this->ids[$id]
            : [];
    }

    /**
     * Add style by element name
     * 
     * @param string $element
     * @param array  $styles
     */
    public function addByElement($element, array $styles)
    {
        $this->elements[$element] = array_merge_recursive($this->getByElement($element), $styles);
    }

    /**
     * Get style by element name
     * 
     * @param  string $element
     * @return array
     */
    public function getByElement($element)
    {
        return array_key_exists($element, $this->elements)
            ? $this->elements[$element]
            : [];
    }
}