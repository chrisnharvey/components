<?php

namespace Encore\View\Style;

class StyleCollection
{
    protected $classes = [];
    protected $ids = [];
    protected $elements = [];

    public function addByClass($class, array $styles)
    {
        $this->classes[$class] = array_merge_recursive($this->getByClass($class), $styles);
    }

    public function getByClass($class)
    {
        return array_key_exists($class, $this->classes)
            ? $this->classes[$class]
            : [];
    }

    public function addById($id, array $styles)
    {
        $this->ids[$id] = array_merge_recursive($this->getById($id), $styles);
    }

    public function getById($id)
    {
        return array_key_exists($id, $this->ids)
            ? $this->ids[$id]
            : [];
    }

    public function addByElement($element, array $styles)
    {
        $this->elements[$element] = array_merge_recursive($this->getByElement($element), $styles);
    }

    public function getByElement($element)
    {
        return array_key_exists($element, $this->elements)
            ? $this->elements[$element]
            : [];
    }
}