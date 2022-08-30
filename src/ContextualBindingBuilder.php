<?php

namespace Openphp\Container;


class ContextualBindingBuilder
{
    /**
     * @var Container
     */
    protected $concrete;
    /**
     * @var string|array
     */
    protected $container;
    /**
     * @var string
     */
    protected $needs;

    /**
     * @param Container $container
     * @param $concrete
     */
    public function __construct(Container $container, $concrete)
    {
        $this->concrete  = $concrete;
        $this->container = $container;
    }

    /**
     * @param $abstract
     * @return $this
     */
    public function needs($abstract)
    {
        $this->needs = $abstract;
        return $this;
    }

    public function give($implementation)
    {
        foreach (Util::arrayWrap($this->concrete) as $concrete) {
            $this->container->addContextualBinding($concrete, $this->needs, $implementation);
        }
    }

    public function giveTagged($tag)
    {
        $this->give(function ($container) use ($tag) {
            $taggedServices = $container->tagged($tag);
            return is_array($taggedServices) ? $taggedServices : iterator_to_array($taggedServices);
        });
    }

    public function giveConfig($key, $default = null)
    {
        $this->give(function ($container) use ($key, $default) {
            return $container->get('config')->get($key, $default);
        });
    }
}