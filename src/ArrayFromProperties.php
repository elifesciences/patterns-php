<?php

namespace eLife\Patterns;

trait ArrayFromProperties
{
    final public function toArray() : array
    {
        return get_object_vars($this);
    }
}
