<?php

namespace eLife\Patterns;
use ReturnTypeWillChange;

trait ArrayAccessFromProperties
{
    use ReadOnlyArrayAccess;

    final public function offsetExists($offset) : bool
    {
        if ('_' === substr($offset, 0, 1)) {
            return false;
        }

        return isset($this->{$offset});
    }

    #[ReturnTypeWillChange]
    final public function offsetGet($offset)
    {
        if (false === $this->offsetExists($offset)) {
            return null;
        }

        return $this->{$offset};
    }
}
