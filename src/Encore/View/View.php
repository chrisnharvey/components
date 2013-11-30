<?php

namespace Encore\View;

use Encore\View\Object\Frame;

class View
{
    public function __construct($path)
    {
        // Initialize wxXmlResource and load the view
        \wxXmlResource::Get()->InitAllHandlers();
        \wxXmlResource::Get()->Load($path);
    }

    public function getFrame($frame)
    {
        $instance = new \wxFrame;
        \wxXmlResource::Get()->LoadFrame($instance, null, $frame);

        return new Frame($instance);
    }
}