<?php

namespace Encore\GIML;

trait ElementTrait
{
    protected $parent;
    protected $collection;
    protected $value;
    protected $attributes = [];
    protected $children = [];

    public function init() {}

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setParent(ElementInterface $parent)
    {
        $this->parent = $parent;
    }

    public function setCollection(CollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function addChild(ElementInterface $child)
    {
        $this->children[] = $child;
    }

    public function __get($property)
    {
        return isset($this->attributes[$property])
            ? $this->attributes[$property]
            : null;
    }

    public function __set($property, $value)
    {
        $this->attributes[$property] = $value;
    }

    public function __clone()
    {
        $this->init();
    }
}