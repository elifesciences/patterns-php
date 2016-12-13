<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Listing implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $isOrdered;
    private $prefix;
    private $items;

    private function __construct(bool $isOrdered, string $prefix = null, array $items)
    {
        Assertion::nullOrChoice($prefix,
            ['alpha-lower', 'alpha-upper', 'bullet', 'number', 'roman-lower', 'roman-upper']);
        Assertion::notEmpty($items);
        Assertion::allString($items);

        $this->isOrdered = $isOrdered;
        $this->prefix = $prefix;
        $this->items = $items;
    }

    public static function ordered(array $items, string $prefix = null) : Listing
    {
        return new self(true, $prefix, $items);
    }

    public static function unordered(array $items, string $prefix = null) : Listing
    {
        return new self(false, $prefix, $items);
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/list.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/list.mustache';
    }
}
