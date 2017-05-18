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

    private $heading;
    private $headingId;
    private $items;

    public function __construct(array $items, string $heading, string $headingId = null)
    {
        Assertion::notEmpty($items);
        Assertion::notBlank($heading);

        $this->heading = $heading;
        $this->headingId = $headingId;
        $this->items = $items;
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/carousel.css';
        yield 'resources/assets/css/list-heading.css';
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/carousel.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->items;
    }
}
