<?php

namespace eLife\Patterns;

use BadMethodCallException;

trait ReadOnlyArrayAccess
{
    final public function offsetExists($offset) : bool
    {
        if ('_' === substr($offset, 0, 1)) {
            return false;
        }

        return isset($this->{$offset});
    }

    final public function offsetGet($offset)
    {
        if (false === $this->offsetExists($offset)) {
            return null;
        }

        return $this->{$offset};
    }

    final public function offsetSet($offset, $value)
    {
        throw new BadMethodCallException('Object is immutable');
    }

    final public function offsetUnset($offset)
    {
        throw new BadMethodCallException('Object is immutable');
    }
}
