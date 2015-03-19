<?php

namespace Encore\Giml;

interface CollectionInterface
{
    /**
     * Add an element to the collection
     * 
     * @param ElementInterface $element
     */
    public function add(ElementInterface $element);

    /**
     * Get an element by its ID
     * @param  string $id
     * @return ElementInterface
     */
    public function getElementById($id);
}