<?php
namespace Flowr\Util;

class Storage extends \ArrayObject
{
    function toArray()
    {
        return (array)$this;
    }

    function fromArray(array $arr)
    {
        return $this->exchangeArray($arr);
    }

    function has($needle, $strict=true)
    {
        $self = (array)$this;
        return in_array($needle, $self, $strict);
    }

    function push(/* arg1, arg2, arg3, ... */)
    {
        $args = func_get_args();
        foreach ($args as $v) {
            $this[] = $v;
        }

        return $this;
    }

    function pop()
    {
        $self = (array)$this;
        $pop = array_pop($self);
        $this->exchangeArray($self);

        return $pop;
    }

    function unshift(/* arg1, arg2, arg3, ... */)
    {
        $self = (array)$this;
        $unshift = array_merge(func_get_args(), $self);
        $this->exchangeArray($unshift);

        return $this;
    }

    function shift()
    {
        $self = (array)$this;
        $shift = array_shift($self);
        $this->exchangeArray($self);

        return $shift;
    }

    function map($fn)
    {
        $mapped = array_map($fn, (array)$this);

        return new self($mapped);
    }

    function __call($method, $args)
    {
        $method = preg_replace('/[A-Z]/', '_$0', $method);
        $lastPos = strlen($method) - 1;
        if ($method[$lastPos] === '_') {
            $method = substr($method, 0, -1);
            $chain = true;
        } else {
            $chain = false;
        }
        $func = 'array_' . $method;
        $self = (array)$this;
        $args = array_merge(array(&$self), $args);

        if (!function_exists($func)) {
            throw new \BadMethodCallException("$func is not exists.");
        }

        $res = call_user_func_array($func, $args);
        if (is_array($res)) {
            $this->exchangeArray($res);
            return $this;
        } elseif ($chain) {
            $this->exchangeArray($self);
            return $this;
        } else {
            return $res;
        }
    }
}
