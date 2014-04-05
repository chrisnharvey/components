<?php

namespace Encore\GIML;

interface ElementInterface
{
    public function init();

    public function setAttributes(array $attributes);

    public function setValue($value);

    public function setParent(ElementInterface &$parent);

    public function getParent();

    public function setCollection(CollectionInterface $collection);

    public function addChild(ElementInterface &$child);

    public function getRaw();
}