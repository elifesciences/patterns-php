<?php

namespace eLife\Patterns;

use ArrayObject;
use Traversable;

trait ComposedAssets
{
    final public function getStyleSheets() : Traversable
    {
        yield from $this->getLocalStyleSheets();
        foreach (array_filter(iterator_to_array($this->getComposedViewModels())) as $viewModel) {
            yield from $viewModel->getStyleSheets();
        }
    }

    final public function getJavaScripts() : Traversable
    {
        yield from $this->getLocalJavaScripts();
        foreach (array_filter(iterator_to_array($this->getComposedViewModels())) as $viewModel) {
            yield from $viewModel->getJavaScripts();
        }
    }

    protected function getLocalStyleSheets() : Traversable
    {
        return new ArrayObject();
    }

    protected function getLocalJavaScripts() : Traversable
    {
        return new ArrayObject();
    }

    abstract protected function getComposedViewModels();
}
