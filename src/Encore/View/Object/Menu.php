<?php

namespace Encore\View\Object;

class Menu extends Bindable
{
    public function __construct($name)
    {
        $this->object = \wxXmlResource::Get()->LoadMenu($name);
    }
}