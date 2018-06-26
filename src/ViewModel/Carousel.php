<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;
use Traversable;

final class Carousel implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $heading;
    private $items;

    public function __construct(array $items, ListHeading $heading)
    {
        Assertion::notEmpty($items);

        $this->heading = $heading;
        $this->items = $items;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/carousel.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->items;
        yield $this->heading;
    }
}
