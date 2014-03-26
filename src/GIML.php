<?php

namespace Encore\GIML;

use Encore\GIML\Exception\InvalidElementException;

class GIML
{
    protected $id;
    protected $namespace;
    protected $reader;

    public function __construct(ReaderInterface $reader, IdentifierInterface $id, $namespace)
    {
        dl('wxwidgets.so');
        $this->reader = $reader;
        $this->id = $id;
        $this->namespace = $namespace;
    }

    public function parse($file)
    {
        $this->reader->open($file);
        $parsed = $this->reader->parse();

        $data = $this->parseIt($parsed['value']);

        //print_r($data); exit;

        current($data)->getRaw()->Show();
    }

    protected function parseIt(array $elements, ElementInterface $parent = null)
    {
        foreach ($elements as $element) {
            $object = $this->newObject($element['name']);

            if ( ! array_key_exists('id', $element['attributes'])) {
                $element['attributes']['id'] = $this->id->generate();
            } else {
                $this->id->reserve($element['attributes']['id']);
            }

            $object->setAttributes($element['attributes']);

            if ( ! is_array($element['value'])) {
                $object->setValue(trim($element['value']));
            }

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