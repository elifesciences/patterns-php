<?php

namespace eLife\Patterns;

use Traversable;

interface HasAssets
{
    public function getStyleSheets() : Traversable;

    public function getInlineStyleSheets() : Traversable;

    public function getJavaScripts() : Traversable;

    public function getInlineJavaScripts() : Traversable;
}
