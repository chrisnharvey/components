<?php

namespace Encore\View;

class Manager
{
    public function make($view)
    {
        return new View($view);
    }
}