<?php

namespace Openphp\Container\Tests;


use Openphp\Container\ServiceProvider;

class DemoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('demo', function ($app) {
            return new Demo();
        });
    }
}