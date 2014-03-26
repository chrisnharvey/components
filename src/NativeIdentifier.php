<?php

namespace Encore\GIML;

use Encore\GIML\Exception\DuplicateIdException;

class NativeIdentifier implements IdentifierInterface
{
    protected $ids = [];

    public function generate()
    {
        return $this->reserve(uniqid('auto'));
    }

    public function reserve($id)
    {
        if (in_array($id, $this->ids)) {
            throw new DuplicateIdException("The ID '{$id}' is already in use");
        }

        return $this->ids[] = $id;
    }
}