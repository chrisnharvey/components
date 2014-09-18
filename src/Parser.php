<?php

namespace Encore\Giml;

use Encore\Giml\Reservation\ReservationInterface;
use Encore\Giml\Exception\InvalidElementException;

class Parser
{
    protected $collection;
    protected $elementFactory;
    protected $reader;
    protected $reservations = [];

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

    public function getReader()
    {
        return $this->reader;
    }

    public function parseElements(array $elements, ElementInterface $parent = null)
    {
        foreach ($elements as $element) {
            try {
                $object = $this->elementFactory->make($element['name']);
            } catch (InvalidElementException $e) {
                $object = $this->getReservation($element['name']);
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

            if ($object instanceof ReservationInterface) {
                $object = $object->getElement($this, $parent);
            }

            $data[] = $object;
        }

        return $data;
    }

    public function addReservation($name, ReservationInterface $reservation)
    {
        $this->reservations[$name] = $reservation;
    }

    public function getReservation($name)
    {
        if (array_key_exists($name, $this->reservations)) {
            return $this->reservations[$name];
        }

        throw new InvalidElementException("Element '{$name}' does not exist");
    }
}
