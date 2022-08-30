<?php

namespace Openphp\Container\Tests;

use Openphp\Container\Facade;

class DemoFacade extends Facade
{
    protected static function getFacadeClass()
    {
        return 'demo';
    }
}