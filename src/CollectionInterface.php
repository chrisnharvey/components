<?php

namespace Encore\Giml;

interface CollectionInterface
{
    public function add(ElementInterface $element);

    public function getElementById($id);
}