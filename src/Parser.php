<?php

namespace Encore\Giml;

use Encore\Giml\Exception\InvalidElementException;

class Parser
{
    protected $collection;
    protected $elementFactory;
    protected $reader;

    public function __construct(ReaderInterface $reader, CollectionInterface $collection, ElementFactoryInterface $elementFactory)
    {
        $this->reader = $reader;
        $this->collection = $collection;
        $this->elementFactory = $elementFactory;
    }

    public function parse($file)
    {
        $this->reader->open($file);
        $parsed = $this->reader->parse();

        $data = $this->parseIt($parsed['value']);

        return $this->collection;
    }

    protected function parseIt(array $elements, ElementInterface $parent = null)
    {
        foreach ($elements as $element) {
            $object = $this->elementFactory->make($element['name']);

            // Set some stuff
            $object->setCollection($this->collection);
            $object->setAttributes($element['attributes']);

            if ( ! is_array($element['value'])) {
                $object->setValue(trim($element['value']));
            }

            // Add the object to the collection
            $this->collection->add($object);

            if ($parent) {
                $object->setParent($parent);
                $parent->addChild($object);
            }

            // Initialize object
            $object->init();

            if (is_array($element['value'])) {
                $this->parseIt($element['value'], $object);
            }

            $data[] = $object;
        }

        return $data;
    }

    public function addReservation(ReservationInterface $reservation)
    {
        // Reservations are classes that handle reserved elements,
        // like Require.
    }
}