<?php

namespace eLife\Patterns;

use Traversable;

trait ComposedAssets
{
    abstract protected function getComposedViewModels() : Traversable;
}
