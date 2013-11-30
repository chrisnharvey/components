<?php

namespace Encore\View;

use Encore\View\Object\Frame;
use Encore\View\Object\Dialog;
use Encore\View\Object\Panel;

class View
{
    public function __construct($path)
    {
        // Initialize wxXmlResource and load the view
        \wxXmlResource::Get()->InitAllHandlers();
        \wxXmlResource::Get()->Load($path);
    }

    public function getFrame($name)
    {
        $instance = new \wxFrame;
        \wxXmlResource::Get()->LoadFrame($instance, null, $name);

        return new Frame($instance);
    }

    public function getDialog($name)
    {
        $instance = new \wxDialog;
        \wxXmlResource::Get()->LoadDialog($instance, null, $name);

        return new Dialog($instance);
    }

    public function getPanel($name)
    {
        $instance = new \wxPanel;
        \wxXmlResource::Get()->LoadPanel($instance, null, $name);

        return new Panel($instance);
    }
}