<?php

namespace Encore\Foundation;

class WxApplication extends \wxApp 
{
    private $app;

    public function setApplication(Application $app)
    {
        $this->app = $app;
    }

    public function OnInit()
    {
        // Run application befores
    }

    public function OnExit()
    {
        $this->app->quit();
    }
}