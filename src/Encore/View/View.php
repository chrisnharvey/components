<?php

namespace Encore\View;

use Encore\View\Object\Frame;

class View
{
    public function __construct($path)
    {
        // Initialize wxXmlResource and load the view
        $xrc = new wxXmlResource();
        wxXmlResource::Get()->InitAllHandlers();
        wxXmlResource::Get()->Load($path);
    }

    public function getFrame($frame)
    {
        $frame = new wxFrame;
        wxXmlResource::Get()->LoadFrame($frame, null, $frame);

        return new Frame($frame);
    }
}