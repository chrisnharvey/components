<?php

namespace Encore\GIML;

use Encore\GIML\Exception\DuplicateIdException;

class ElementCollection implements CollectionInterface
{
    protected $objects = [];
    protected $ids = [];

    public function add(ElementInterface $element)
    {
        if ($element->id === null) $id = $this->generateId();

        $this->checkId($id);

        $this->objects[] = $element;
        $this->ids[array_search($element, $this->objects, true)] = $id;
    }

    public function getTrueId($id)
    {
        return array_search($id, $this->ids, true);
    }

    public function generateId()
    {
        return uniqid('auto', true);
    }

    protected function checkId($id)
    {
        if (in_array($id, $this->ids)) {
            throw new DuplicateIdException("The ID '{$id}' is already in use");
        }
    }
}