<?php

namespace Encore\Foundation\Command;

use Encore\Foundation\GUI;

class Run extends \Encore\Console\Command
{
    protected $name = 'run';
    protected $description = 'Run the application';

    private $gui;

    public function fire()
    {
        if (defined('PHPUNIT_RUNNING')) {
            Testing::start();
        } elseif ( ! extension_loaded('wxwidgets')) {
            dl('wxwidgets.' . PHP_SHLIB_SUFFIX);
        }

        $this->gui = new GUI;
        $this->gui->setApplication(\App::get());

        \wxApp::SetInstance($this->gui);

        WxEntry();
    }
}