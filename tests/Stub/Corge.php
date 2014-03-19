<?php
/**
 * This file is part of the Encore\Container library.
 * Originally part of the League\Di package.
 *
 * (c) Don Gilbert <don@dongilbert.net>
 * (c) Chris Harvey <chris@chrisnharvey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Encore\Container\Test\Stub;

/**
 * Corge Stub Test class
 *
 * @author  Don Gilbert <don@dongilbert.net>
 */
class Corge
{
    public $int;

    public function __construct($int = null)
    {
        $this->int = $int;
    }

    public function setInt($int)
    {
        $this->int = $int;
    }
}
