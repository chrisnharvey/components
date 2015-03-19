<?php

namespace Encore\Development\Task\Composer;

use Robo\Task\Composer\Install;
use Robo\Task\Composer\Update;
use Robo\Task\Composer\DumpAutoload;

trait loadTasks
{
    /**
     * @param null $pathToComposer
     * @return Install
     */
    protected function taskComposerInstall($pathToComposer = null)
    {
        return new Install($pathToComposer ?: 'bin/composer');
    }

    /**
     * @param null $pathToComposer
     * @return Update
     */
    protected function taskComposerUpdate($pathToComposer = null)
    {
        return new Update($pathToComposer ?: 'bin/composer');
    }

    /**
     * @param null $pathToComposer
     * @return DumpAutoload
     */
    protected function taskComposerDumpAutoload($pathToComposer = null)
    {
        return new DumpAutoload($pathToComposer ?: 'bin/composer');
    }

} 