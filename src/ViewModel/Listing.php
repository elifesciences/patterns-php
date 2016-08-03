<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ListingItem;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Listing implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $seeMoreLink;
    private $loadMore;

    private function __construct(string $heading, array $items, ListingItem $listingItem)
    {
        Assertion::notEmpty($items);
        if ($listingItem instanceof Button) {
            $this->loadMore = $listingItem;
        }
        if ($listingItem instanceof SeeMoreLink) {
            $this->seeMoreLink = $listingItem;
        }
    }

    public static function withProfileSnippets($heading, ListingItem $listingItem, ProfileSnippet ...$items)
    {
        return new static($heading, $items, $listingItem);
    }

    public static function withTeasers($heading, ListingItem $listingItem, Teaser ...$items)
    {
        return new static($heading, $items, $listingItem);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/listing.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/listing.css';
    }
}
