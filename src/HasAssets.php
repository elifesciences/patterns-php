<?php

namespace eLife\Patterns;

use Traversable;

interface HasAssets
{
    public function getStyleSheets() : Traversable;

    public function getJavaScripts() : Traversable;
}
