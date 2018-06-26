<?php

namespace eLife\Patterns;

use ArrayObject;
use Traversable;

trait ComposedAssets
{
    abstract protected function getComposedViewModels() : Traversable;
}
