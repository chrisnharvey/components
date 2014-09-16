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

        $data = $this->parseElements($parsed['value']);

        return $this->collection;
    }

    public function parseElements(array $elements, ElementInterface $parent = null)
    {
        foreach ($elements as $element) {
            try {
                $object = $this->elementFactory->make($element['name']);
            } catch (InvalidElementException $e) {
                // Try to find a reservation for this element and set $object to that
                // if its an instance of ElementInterface, if its an array then just set
                // $element and try to re-make the object using element factory.
                // If no reservation is found then rethrow $e
                throw $e;
            }
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
                $this->parseElements($element['value'], $object);
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
