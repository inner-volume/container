<?php

namespace Openphp\Container\Tests;

class Demo
{
    public function func()
    {
        return 'demo_func';
    }

    public function funcArgs($args)
    {
        return $args;
    }
}