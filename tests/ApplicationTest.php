<?php

namespace Openphp\Container\Tests;

use Openphp\Container\Application;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @var Application
     */
    protected $application;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->application = new Application( $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__));
        $this->application->register(DemoServiceProvider::class);
    }

    /**
     * @return void
     */
    public function testAppRegister()
    {
        $demo = $this->application->get('demo');
        $this->assertEquals('demo_func', $demo->func());
        $this->assertEquals('Xqiang', $demo->funcArgs('Xqiang'));
    }

    /**
     * @return void
     */
    public function testAppFacade()
    {
        $this->assertEquals('demo_func', DemoFacade::func());
        $this->assertEquals('Xqiang', DemoFacade::funcArgs('Xqiang'));
    }
}