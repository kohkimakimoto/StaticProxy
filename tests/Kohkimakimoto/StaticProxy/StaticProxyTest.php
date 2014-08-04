<?php
namespace Test\Kohkimakimoto\StaticProxy;

use Kohkimakimoto\StaticProxy\StaticProxy;
use Kohkimakimoto\StaticProxy\StaticProxyContainer;

class StaticProxyTest extends \PHPUnit_Framework_TestCase
{
    public function setup()
    {
        error_reporting(-1);
    }

    public function testDefault()
    {

        $container = new StaticProxyContainer();
        $container->bind("hello", new HelloworldFunctions());

        StaticProxy::setContainer($container);
        StaticProxy::addAlias("Hw", "Test\Kohkimakimoto\StaticProxy\Helloworld");

        $this->assertEquals("hello world", Helloworld::helloWorld());
        $this->assertEquals("hello world", \Hw::helloWorld());

        StaticProxy::bind("hello", new HelloworldFunctionsMock());
        $this->assertEquals("hello world mock", Helloworld::helloWorld());
    }
}

class Helloworld extends StaticProxy
{
    public static function getAccessor() { return 'hello'; }
}

class HelloworldFunctions
{
    public function helloWorld()
    {
        return "hello world";
    }

    public function hello($name)
    {
        return "hello $name";
    }
}

class HelloworldFunctionsMock
{
    public function helloWorld()
    {
        return "hello world mock";
    }

    public function hello()
    {
        return "hello mock";
    }
}
