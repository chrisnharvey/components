<?php
/**
 * This file is part of the Encore\Container library.
 *
 * (c) Chris Harvey <chris@chrisnharvey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Encore\Container;

interface EventDispatcherInterface
{
    /**
     * Listen for a specific event to occur
     *
     * @param string $event
     * @param Closure $trigger
     * @return void
     */
    public function listen($event, \Closure $trigger);
}