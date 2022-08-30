<?php

namespace Openphp\Container;

/**
 * @param $abstract
 * @param array $parameters
 * @return mixed|object|Container
 * @throws BindingResolutionException
 */
function app($abstract = null, array $parameters = [])
{
    if (is_null($abstract)) {
        return Container::getInstance();
    }
    return Container::getInstance()->make($abstract, $parameters);
}

/**
 * @param $path
 * @return mixed
 * @throws BindingResolutionException
 */
function app_path($path = '')
{
    return app()->path($path);
}

/**
 * @param $path
 * @return mixed
 * @throws BindingResolutionException
 */
function base_path($path = '')
{
    return app()->basePath($path);
}

/**
 * @param $path
 * @return mixed
 * @throws BindingResolutionException
 */
function runtime_path($path = '')
{
    return app()->runtimePath($path);
}