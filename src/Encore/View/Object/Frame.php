<?php

namespace Encore\View\Object;

use Closure;
use Encore\View\ClosureCallback;

class Frame extends Object
{
    protected $xml;
    protected $closures = array();

    public function bind($name, $event, $callback)
    {
        $event = $this->findEvent($event);

        $objectId = \wxXmlResource::Get()->GetXRCID($name);

        if ($objectId === false) {
            throw new \RuntimeException("Object with name '{$name}' was not found");
        }

        if ($callback instanceof Closure) {
            $callback = array(new ClosureCallback($callback), "call");
        }

        $this->object->Connect($objectId, $event, $callback);

        return $this;
    }

    protected function findEvent($event)
    {
        // If the correct constant has been passed over already, use that
        if (defined($event)) return constant($event);

        // Make the event name uppercase
        $eventUpper = strtoupper($event);

        // Try to find the directly from the constant
        if (defined("wxEVT_COMMAND_{$eventUpper}")) return constant("wxEVT_COMMAND_{$eventUpper}");

        // Couldn't find it. Throw an exception
        throw new \RuntimeException("'{$event}' is not a valid event");
    }
}