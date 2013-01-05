<?php
namespace Flowr\Util;

class AdviceStorage extends Storage
{
    function offsetSet($offset, $value)
    {
        if (is_callable($value)) {
            parent::offsetSet($offset, $value);
        } else {
            throw new \InvalidArgumentException('Value must be callable.');
        }
    }
}
