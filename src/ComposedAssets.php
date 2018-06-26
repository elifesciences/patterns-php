<?php

namespace eLife\Patterns;

use ArrayObject;
use Traversable;

trait ComposedAssets
{
    final public function getJavaScripts() : Traversable
    {
        yield from $this->getLocalJavaScripts();
        foreach (array_filter(iterator_to_array($this->getComposedViewModels(), false)) as $viewModel) {
            yield from $viewModel->getJavaScripts();
        }
    }

    protected function getLocalJavaScripts() : Traversable
    {
        return new ArrayObject();
    }

    abstract protected function getComposedViewModels() : Traversable;
}
