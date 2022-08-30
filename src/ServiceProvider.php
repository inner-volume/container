<?php

namespace Openphp\Container;

use Closure;

abstract class ServiceProvider
{
    /**
     *
     * @var Application
     */
    protected $app;
    /**
     * All of the registered booting callbacks.
     *
     * @var array
     */
    protected $bootingCallbacks = [];

    /**
     * All of the registered booted callbacks.
     *
     * @var array
     */
    protected $bootedCallbacks = [];

    /**
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @return void
     */
    public function register()
    {
       // todo register
    }

    /**
     * @return void
     */
    public function callBootingCallbacks()
    {
        $index = 0;
        while ($index < count($this->bootingCallbacks)) {
            $this->app->call($this->bootingCallbacks[$index]);
            $index++;
        }
    }

    /**
     * @return void
     */
    public function callBootedCallbacks()
    {
        $index = 0;
        while ($index < count($this->bootedCallbacks)) {
            $this->app->call($this->bootedCallbacks[$index]);
            $index++;
        }
    }
}