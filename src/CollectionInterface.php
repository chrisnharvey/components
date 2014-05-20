<?php

namespace Encore\GIML;

interface CollectionInterface
{
    public function add(ElementInterface $element);

    public function getElementById($id);
}