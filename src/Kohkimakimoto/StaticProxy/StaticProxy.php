<?php
/*
This class refers to `Illuminate\Support\Facades\Facade` that is a part of laravel framework.

https://github.com/laravel/framework

The MIT License (MIT)

Copyright (c) <Taylor Otwell>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
namespace Kohkimakimoto\StaticProxy;

/**
 * StaticProxy
 */
class StaticProxy
{
    protected static $instances = array();

    protected static $container;

    protected static $aliases = array();

    protected static $aliasesRegistered = false;

    public static function setContainer($container)
    {
        static::$container = $container;
    }

    public static function getContainer()
    {
        return static::$container;
    }

    public static function bind($name, $concrete = null)
    {
        return static::$container->bind($name, $concrete);
    }

    public static function getBackendInstance()
    {
        $name = static::getAccessor();

        if (is_object($name)) {
            return $name;
        }

        return static::$container->get($name);
    }

    public static function getAccessor()
    {
        throw new \RuntimeException("Proxy does not implement getAccessor method.");
    }

    public static function addAlias($alias, $class)
    {
        static::$aliases[$alias] = $class;
        if (!static::$aliasesRegistered) {
            spl_autoload_register('static::load', true, true);
            static::$aliasesRegistered = true;
        }
    }

    public static function load($alias)
    {
        if (isset(static::$aliases[$alias])) {
            return class_alias(static::$aliases[$alias], $alias);
        }
    }

    public static function __callStatic($method, $args)
    {
        $instance = static::getBackendInstance();

        return call_user_func_array(array($instance, $method), $args);
    }
}
