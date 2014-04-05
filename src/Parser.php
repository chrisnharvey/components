<?php

namespace Encore\GIML;

use Encore\GIML\Exception\InvalidElementException;

class Parser
{
    protected $collection;
    protected $namespace;
    protected $reader;

    public function __construct(ReaderInterface $reader, CollectionInterface $collection, $namespace)
    {
        $this->reader = $reader;
        $this->collection = $collection;
        $this->namespace = $namespace;
    }

    public function parse($file)
    {
        $this->reader->open($file);
        $parsed = $this->reader->parse();

        $data = $this->parseIt($parsed['value']);

        return $this->collection;
    }

    protected function parseIt(array $elements, ElementInterface &$parent = null)
    {
        foreach ($elements as $element) {
            $object = $this->newObject($element['name']);

            // Set some stuff
            $object->setCollection($this->collection);
            $object->setAttributes($element['attributes']);

            if ( ! is_array($element['value'])) {
                $object->setValue(trim($element['value']));
            }

            // Add the object to the collection
            $this->collection->add($object);

            // Initialize object
            $object->init();

            if ($parent) {
                $object->setParent($parent);
                $parent->addChild($object);
            }

            if (is_array($element['value'])) {
                $this->parseIt($element['value'], $object);
            }

            $data[] = $object;

            // Garbage collection
            $object = null;
        }

        return $data;
    }

    public function addReservation(ReservationInterface $reservation)
    {
        // Reservations are classes that handle reserved elements,
        // like Require.
    }

    protected function newObject($element)
    {
        $class = "{$this->namespace}\\{$element}";

        if ( ! class_exists($class)) {
            throw new InvalidElementException("Handler for '{$element}' not found");
        }

        $object = new $class;

        if ( ! $object instanceof ElementInterface) {
            throw new InvalidElementException('Element must be an instance of ElementInterface');
        }

        return $object;
    }
}