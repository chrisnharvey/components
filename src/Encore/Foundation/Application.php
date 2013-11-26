<?php

namespace Encore\Foundation;

use Illuminate\Container\Container;

class Application extends Container
{
    private $wxApp;

    public function __construct()
    {
        $this->wxApp = new WxApplication;

        wxApp::SetInstance($this->wxApp);
        wxApp::SetAppName('EncorePHP');
        wxApp::SetVendorName('EncorePHP');
    }

    public function run()
    {
        wxEntry();
    }
}