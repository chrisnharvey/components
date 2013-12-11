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
        $this->app->launch();
    }

    public function OnExit()
    {
        $this->app->quit();
    }
}
