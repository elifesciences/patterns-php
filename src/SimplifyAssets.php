<?php

namespace eLife\Patterns;

use ArrayObject;
use Traversable;

trait SimplifyAssets
{
    public function getJavaScripts() : Traversable
    {
        return new ArrayObject();
    }
}
