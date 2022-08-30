<?php

namespace Openphp\Container;

use Psr\Container\ContainerExceptionInterface;
use Exception;


class CircularDependencyException extends Exception implements ContainerExceptionInterface
{
    //
}
