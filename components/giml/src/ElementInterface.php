<?php

namespace Encore\Giml;

interface ElementInterface
{
    /**
     * Initialize the element
     * 
     * @return void
     */
    public function init();

    /**
     * Called when the element is ready
     * 
     * @return void
     */
    public function ready();

    /**
     * Set the elements attributes
     * 
     * @param array $attributes
     */
    public function setAttributes(array $attributes);

    /**
     * Set a single attribute
     * 
     * @param string $key
     * @param mixed $value
     */
    public function setAttribute($key, $value);

    /**
     * Get an attribute value by its key
     * 
     * @param  string $key
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * Set the elements value
     * 
     * @param mixed $value
     */
    public function setValue($value);

    /**
     * Get the elements value
     * 
     * @return mixed
     */
    public function getValue();

    /**
     * Remove the element from the collection
     * 
     * @return void
     */
    public function remove();

    /**
     * Destroy the element
     * 
     * @return void
     */
    public function destroy();

    /**
     * Set the parent element
     * 
     * @param ElementInterface $parent
     */
    public function setParent(ElementInterface $parent);

    /**
     * Get the parent element
     * 
     * @return ElementInterface
     */
    public function getParent();

    /**
     * Set the collection
     * 
     * @param CollectionInterface $collection
     */
    public function setCollection(CollectionInterface $collection);

    /**
     * Add a child element
     * 
     * @param ElementInterface $child
     */
    public function addChild(ElementInterface $child);

    /**
     * Get the raw element object
     * 
     * @return mixed
     */
    public function getRaw();

    /**
     * Convert the element to a string (get the value)
     * 
     * @return string
     */
    public function __toString();

    /**
     * Get an element attribute using __get magic method
     * 
     * @param  string $property
     * @return mixed
     */
    public function __get($property);

    /**
     * Set an element attribute using __set magic method
     * 
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value);
}