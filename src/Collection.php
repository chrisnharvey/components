<?php

namespace Encore\GIML;

use Encore\GIML\Exception\DuplicateIdException;

class ElementCollection implements CollectionInterface
{
    protected $objects = [];

    public function add(ElementInterface $element)
    {
        $id = $element->id;

        if ($id === null) $id = $this->generateId();

        $this->checkId($id);

        $this->objects[$id] = $element;
    }

    public function getElementById($id)
    {
        return $this->objects[$id];
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