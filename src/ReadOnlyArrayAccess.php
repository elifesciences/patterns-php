<?php

namespace eLife\Patterns;

use BadMethodCallException;

trait ReadOnlyArrayAccess
{
    final public function offsetSet($offset, $value): void
    {
        throw new BadMethodCallException('Object is immutable');
    }

    final public function offsetUnset($offset): void
    {
        throw new BadMethodCallException('Object is immutable');
    }
}
