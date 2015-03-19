<?php

namespace Encore\Giml;

use Encore\Giml\Exception\DuplicateIdException;

class ElementCollection implements CollectionInterface
{
    protected $objects = [];

    /**
     * Add an element to the collection
     * 
     * @param ElementInterface $element
     */
    public function add(ElementInterface $element)
    {
        $id = $element->id;

        if ($id === null) $id = $this->generateId();

        $this->checkId($id);

        $this->objects[$id] = $element;
    }

    /**
     * Get an element by its ID
     * @param  string $id
     * @return ElementInterface
     */
    public function getElementById($id)
    {
        return $this->objects[$id];
    }

    /**
     * Generate a unique ID for the element
     * @return string
     */
    public function generateId()
    {
        return uniqid('auto', true);
    }

    /**
     * Check an ID has not been used before
     * 
     * @param  string $id
     * @throws DuplicateIdException
     */
    protected function checkId($id)
    {
        if (in_array($id, $this->ids)) {
            throw new DuplicateIdException("The ID '{$id}' is already in use");
        }
    }
}