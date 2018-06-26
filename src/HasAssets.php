<?php

namespace eLife\Patterns;

use Traversable;

interface HasAssets
{
    public function getJavaScripts() : Traversable;
}
