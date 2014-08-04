<?php
namespace Kohkimakimoto\StaticProxy;

use Closure;

/**
 * StaticProxyContainer
 */
class StaticProxyContainer
{
    protected $instances = array();

    protected $bindings = array();

    public function bind($name, $concrete = null)
    {
        $this->bindings[$name] = $concrete;
        $this->clearInstance($name);
    }

    public function get($name)
    {
        if (!isset($this->bindings[$name])) {
            throw new \InvalidArgumentException(sprintf('The binding "%s" is not defined.', $name));
        }

        if (!isset($this->instances[$name])) {
            $binding = $this->bindings[$name];

            if ($binding instanceof Closure) {
                $this->instances[$name] = $binding($this);
            } elseif (is_string($binding)) {
                $this->instances[$name] = new $binding();
            } else {
                $this->instances[$name] = $binding;
            }
        }

        return $this->instances[$name];
    }

    public function clearInstance($name)
    {
        unset($this->instances[$name]);
    }

    public function clearInstances()
    {
        $this->instances = array();
    }
}
