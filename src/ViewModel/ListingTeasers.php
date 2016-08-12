<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use InvalidArgumentException;
use Traversable;

final class ListingTeasers implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $items;
    private $heading;
    private $loadMore;
    private $seeMoreLink;

    private function __construct(array $items, string $heading = null, LoadMoreButton $loadMore = null, SeeMoreLink $seeMoreLink = null)
    {
        if (
            null !== $loadMore &&
            null !== $seeMoreLink
        ) {
            throw new InvalidArgumentException('You cannot have both LoadMore and SeeMoreLink in Teaser Listings.');
        }
        Assertion::notEmpty($items);
        Assertion::allIsInstanceOf($items, Teaser::class);
        $this->items = $items;
        $this->heading = $heading;
        $this->loadMore = $loadMore;
        $this->seeMoreLink = $seeMoreLink;
    }

    public static function basic(array $items, $heading = null)
    {
        return new static ($items, $heading);
    }

    public static function withLoadMore(array $items, LoadMoreButton $loadMore, $heading = null)
    {
        return new static($items, $heading, $loadMore);
    }

    public static function withSeeMore(array $items, SeeMoreLink $seeMoreLink, string $heading = null)
    {
        return new static($items, $heading, null, $seeMoreLink);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/listing-teasers.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/listing.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->items;
        yield $this->loadMore;
    }
}
