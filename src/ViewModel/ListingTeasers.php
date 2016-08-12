<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class ListingTeasers implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $items;
    private $heading;
    private $loadMore;

    private function __construct(array $items, string $heading = null, LoadMoreButton $loadMore = null)
    {
        $this->items = $items;
        $this->heading = $heading;
        $this->loadMore = $loadMore;
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
