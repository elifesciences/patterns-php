<?php

namespace eLife\Patterns;

use Traversable;

trait ComposedViewModel
{
    use ComposedAssets;
    use ReadOnlyArrayAccess;

    public function toArray() : array
    {
        return $this->getViewModel()->toArray();
    }

    public function offsetExists($offset) : bool
    {
        return $this->getViewModel()->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->getViewModel()->offsetGet($offset);
    }

    final protected function getComposedViewModels() : Traversable
    {
        yield $this->getViewModel();
    }

    abstract protected function getViewModel() : ViewModel;
}
