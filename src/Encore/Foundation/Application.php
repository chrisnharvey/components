<?php

namespace Encore\Foundation;

class Application 
{
    public function __construct()
    {
        $this->app = new App;

        wxApp::SetInstance($this->app);
        wxApp::SetAppName('EncorePHP');
        wxApp::SetVendorName('EncorePHP');
    }

    public function run()
    {
        wxEntry();
    }
}