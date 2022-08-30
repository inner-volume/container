<?php

namespace Openphp\Container;

class Application extends Container
{
    /**
     * The base path for the Laravel installation.
     *
     * @var string
     */
    protected $basePath;
    /**
     * @var mixed
     */
    protected $serviceProviders;
    /**
     * @var
     */
    protected $loadedProviders;
    /**
     * @var bool
     */
    protected $booted = false;
    /**
     * @var mixed
     */
    protected $appPath;

    /**
     * @param $basePath
     */
    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->basePath = rtrim($basePath, '\/');
        }
        $this->registerBaseBindings();
        $this->bindPathsInContainer();
    }

    /**
     * @return void
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);
        $this->instance('app', $this);
    }

    /**
     * @return void
     */
    protected function bindPathsInContainer()
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.runtime', $this->runtimePath());
    }

    /**
     * @param $path
     * @return string
     */
    public function path($path = '')
    {
        $appPath = $this->appPath ?: $this->basePath . DIRECTORY_SEPARATOR . 'app';
        return $appPath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param $path
     * @return string
     */
    public function basePath($path = '')
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param $path
     * @return string
     */
    public function runtimePath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'runtime' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param  $provider
     * @param bool $force
     * @return mixed
     */
    public function register($provider, bool $force = false)
    {
        if (($registered = $this->getProvider($provider)) && !$force) {
            return $registered;
        }
        if (is_string($provider)) {
            $provider = $this->resolveProvider($provider);
        }
        $provider->register();
        if (property_exists($provider, 'bindings')) {
            foreach ($provider->bindings as $key => $value) {
                $this->bind($key, $value);
            }
        }
        if (property_exists($provider, 'singletons')) {
            foreach ($provider->singletons as $key => $value) {
                $this->singleton($key, $value);
            }
        }
        $this->markAsRegistered($provider);
        if ($this->isBooted()) {
            $this->bootProvider($provider);
        }
        return $provider;
    }

    /**
     * @param $provider
     * @return mixed|null
     */
    public function getProvider($provider)
    {
        return array_values($this->getProviders($provider))[0] ?? null;
    }

    /**
     * @param $provider
     * @return array
     */
    public function getProviders($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);
        if ($serviceProviders = $this->serviceProviders) {
            return array_filter($serviceProviders, function ($value) use ($name) {
                return $value instanceof $name;
            }, ARRAY_FILTER_USE_BOTH);
        }
        return [];
    }

    /**
     * @param $provider
     * @return mixed
     */
    public function resolveProvider($provider)
    {
        return new $provider($this);
    }

    /**
     * @param $provider
     * @return void
     */
    protected function markAsRegistered($provider)
    {
        $this->serviceProviders[]                    = $provider;
        $this->loadedProviders[get_class($provider)] = true;
    }

    /**
     * @return mixed
     */
    public function isBooted()
    {
        return $this->booted;
    }

    /**
     * @param ServiceProvider $provider
     * @return void
     */
    protected function bootProvider(ServiceProvider $provider)
    {
        $provider->callBootingCallbacks();
        if (method_exists($provider, 'boot')) {
            $this->call([$provider, 'boot']);
        }
        $provider->callBootedCallbacks();
    }
}