<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class Highlight implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $heading;
    private $items;

    private $heroItem;

    public function __construct(array $items, ListHeading $heading = null, $heroItem = false)
    {
        Assertion::notEmpty($items);
        Assertion::allIsInstanceOf($items, HighlightItem::class);

        $this->heading = $heading;

        /**
         * If $heroItem is true, set the first item as the hero item
         * Else set the all items per usual
         */
        if ($heroItem) {
            $this->heroItem = array_slice($items, 0, 1);
            $this->items = array_slice($items, 1);
        } else {
            $this->items = $items;
        }
    }

    /**
     * Fluent setter of $heroItem
     * @param HighlightItem $item
     * @return $this
     */
    public function withHeroItem(HighlightItem $item): self
    {
        $this->heroItem = $item;
        return $this;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/highlight.mustache';
    }
}
