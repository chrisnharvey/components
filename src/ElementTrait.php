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

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function getAttribute($key)
    {
        return isset($this->attributes[$key])
            ? $this->attributes[$key]
            : null;
    }

    public function destroy()
    {
        $this->collection->destroy($this->id);
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setParent(ElementInterface $parent)
    {
        $this->parent =& $parent;
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
        $this->children[] =& $child;
    }

    public function __toString()
    {
        return $this->getValue();
    }

    public function __get($property)
    {
        return $this->getAttribute($property);
    }

    public function __set($property, $value)
    {
        $this->setAttribute($property, $value);
    }

    public function __clone()
    {
        $this->init();
    }
}