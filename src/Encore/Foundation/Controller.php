<?php

namespace Encore\Foundation;

abstract class Controller
{
    public function __destruct()
    {
        $collection = \App::make('collection');

        // Assign the object to another var
        $that = $this;

        // Change the scope (kinda).
        $savable = function() use ($that) {
            return get_object_vars($that);
        };

        // Save public properties in the collection
        $collection[] = $savable(); 
    }
}