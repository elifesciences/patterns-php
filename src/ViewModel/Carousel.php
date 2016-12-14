<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Carousel implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $items;

    public function __construct(CarouselItem ...$items)
    {
        Assertion::notEmpty($items);

        $this->items = $items;
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/carousel.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/carousel.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->items;
    }
}
