<?php

namespace eLife\Patterns\ViewModel;

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
        $this->items = $items;
        $this->heading = $heading;
        $this->loadMore = $loadMore;
        $this->seeMoreLink = $seeMoreLink;
    }

    public static function basic(Teaser ...$items)
    {
        return new static ($items);
    }

    public static function withoutHeading(LoadMoreButton $loadMore, Teaser ...$items)
    {
        return new static($items, null, $loadMore);
    }

    public static function withHeading(string $heading, LoadMoreButton $loadMore = null, Teaser ...$items)
    {
        return new static($items, $heading, $loadMore);
    }

    public static function withSeeMore(string $heading, SeeMoreLink $seeMoreLink = null, Teaser ...$items)
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
