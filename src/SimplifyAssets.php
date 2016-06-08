<?php

namespace eLife\Patterns;

use ArrayObject;
use Traversable;

trait SimplifyAssets
{
    public function getStyleSheets() : Traversable
    {
        return new ArrayObject();
    }

    public function getInlineStyleSheets() : Traversable
    {
        return new ArrayObject();
    }

    public function getJavaScripts() : Traversable
    {
        return new ArrayObject();
    }

    public function getInlineJavaScripts() : Traversable
    {
        return new ArrayObject();
    }
}
