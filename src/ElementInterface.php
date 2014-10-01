<?php

namespace Encore\Giml;

interface ElementInterface
{
    public function init();

    public function setAttributes(array $attributes);

    public function setAttribute($key, $value);

    public function getAttribute($key);

    public function setValue($value);

    public function getValue();

    public function remove();

    public function destroy();

    public function setParent(ElementInterface $parent);

    public function getParent();

    public function setCollection(CollectionInterface $collection);

    public function addChild(ElementInterface $child);

    public function getRaw();

    public function __toString();

    public function __get($property);

    public function __set($property, $value);
}