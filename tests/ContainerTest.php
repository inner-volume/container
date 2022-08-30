<?php


namespace Openphp\Container\Tests;

use Openphp\Container\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    /**
     * @return void
     */
    public function testEq()
    {
        $this->assertEquals(1, 1);
    }


    /**
     * @return void
     */
    public function testFun()
    {
        $container = Container::getInstance();
        $container->bind('func', function () {
            return 'test';
        });
        $this->assertEquals('test', $container->get('func'));
    }

    /**
     * @return void
     */
    public function testClass()
    {
        $container = Container::getInstance();
        $container->bind('demo', Demo::class);
        $this->assertEquals('demo_func', $container->get('demo')->func());
        $this->assertEquals('Xqiang', $container->get('demo')->funcArgs('Xqiang'));
    }

    /**
     * @return void
     */
    public function testApp()
    {
        $container = Container::getInstance();
        $container->bind('demo', Demo::class);
        $this->assertEquals('demo_func', $container->get('demo')->func());
        $this->assertEquals('Xqiang', $container->get('demo')->funcArgs('Xqiang'));
    }
}
