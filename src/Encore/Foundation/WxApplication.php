<?php

namespace Encore\Foundation;

class WxApplication extends \wxApp 
{
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function OnInit()
    {
        // Run application befores
    }

    public function OnExit()
    {
        // Run application afters
    }
}