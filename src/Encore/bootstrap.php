<?php

// Instantiate the application
$app = new Encore\Foundation\Application(__DIR__.'/app', __DIR__.'/vendor');

// Set the application environment
$app->setEnvironment('production');

// Give facades an instance of the application
Encore\Foundation\Facade::setApplication($app);

// Boot the app
$app->boot();

// Load the wxwidgets extension
if ( ! extension_loaded('wxwidgets')) {
    dl('wxwidgets.' . PHP_SHLIB_SUFFIX);
}

// Instantiate the GUI
$gui = new Encore\Foundation\GUI;

// Register the app to the GUI
$gui->setApplication($app);

// Set the wxApp instance
wxApp::SetInstance($this->gui);

// Ensure the app does not close
WxEntry();