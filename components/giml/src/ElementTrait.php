<?php

namespace Encore\Giml;

trait ElementTrait
{
    protected $parent;
    protected $collection;
    protected $value;
    protected $attributes = [];
    protected $children = [];

    /**
     * Initialize the element
     * 
     * @return void
     */
    public function init() {}

    /**
     * Called when the element is ready
     * 
     * @return void
     */
    public function ready() {}

    /**
     * Set the elements attributes
     * 
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Set a single attribute
     * 
     * @param string $key
     * @param mixed $value
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Get an attribute value by its key
     * 
     * @param  string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return isset($this->attributes[$key])
            ? $this->attributes[$key]
            : null;
    }

    /**
     * Remove the element from the collection
     * 
     * @return void
     */
    public function remove()
    {
        $this->collection->remove($this->id);
    }

    /**
     * Set the elements value
     * 
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get the elements value
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the parent element
     * 
     * @param ElementInterface $parent
     */
    public function setParent(ElementInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Set the collection
     * 
     * @param CollectionInterface $collection
     */
    public function setCollection(CollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Get the parent element
     * 
     * @return ElementInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add a child element
     * 
     * @param ElementInterface $child
     */
    public function addChild(ElementInterface $child)
    {
        $this->children[] = $child;
    }

    /**
     * Convert the element to a string (get the value)
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * Get an element attribute using __get magic method
     * 
     * @param  string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->getAttribute($property);
    }

    /**
     * Set an element attribute using __set magic method
     * 
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
        $this->setAttribute($property, $value);
    }

    /**
     * Clone the element and re-run init.
     * 
     * @return void
     */
    public function __clone()
    {
        $this->init();
    }
}