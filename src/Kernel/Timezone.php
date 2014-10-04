<?php

namespace Encore\Kernel;

class Timezone
{
    public function __construct(Application $app, array $winTimezones)
    {
        $this->app = $app;
        $this->timezones = $winTimezones;
    }

    public function set($timezone)
    {
        return date_default_timezone_set($timezone);
    }

    public function get()
    {
        return date_default_timezone_get();
    }

    public function setToSystem()
    {
        return $this->set($this->getSystemTimezone());
    }

    public function getSystemTimezone()
    {
        if ($this->app->os() === $this->app::OS_WIN) {
            return $this->getWindowsTimezone();
        }

        return $this->getUnitTimezone();
    }

    protected function getUnixTimezone()
    {
        return system('date +%Z');
    }

    protected function getWindowsTimezone()
    {
        $wmiObject = new COM("WinMgmts:\\\\.\\root\\cimv2");
        $wmiObj = $wmiObject->ExecQuery("SELECT Bias FROM Win32_TimeZone");

        foreach ($wmiObj as $objItem) {
            $offset = $objItem->Bias;
            break;
        }

        return array_key_exists($offset/60, $this->timezones) ? $this->timezones[$offset] : "UTC" ;
    }
}