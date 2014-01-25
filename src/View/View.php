<?php

namespace Encore\View;

use Encore\View\Object\Frame;
use Encore\View\Object\Dialog;
use Encore\View\Object\Panel;
use Encore\View\Object\Menu;

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
        return new Frame($name);
    }

    public function getDialog($name)
    {
        return new Dialog($name);
    }

    public function getPanel($name)
    {
        return new Panel($name);
    }

    public function getMenu($name)
    {
        return new Menu($name);
    }
}