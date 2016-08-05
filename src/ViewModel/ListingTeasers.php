<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\EnsureInstance;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ListingTeasers implements ViewModel
{
    use EnsureInstance;
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $items;
    private $heading;
    private $loadMore;

    private function __construct(array $items, string $heading = null, Button $loadMore = null)
    {
        if (null !== $loadMore) {
            Assertion::same($loadMore['templateName'], 'load-more');
        }

        $this->items = $items;
        $this->heading = $heading;
        $this->loadMore = $loadMore;
    }

    public static function basic(Teaser ...$items)
    {
        return new static ($items);
    }

    public static function withoutHeading(Button $loadMore, Teaser ...$items)
    {
        return new static($items, null, $loadMore);
    }

    public static function withHeading(string $heading, Button $loadMore = null, Teaser ...$items)
    {
        return new static($items, $heading, $loadMore);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/listing-teasers.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/listing.css';
        yield from $this->ensureInstance($this->items[0], Teaser::class)->getStylesheets();
        yield from $this->ensureInstance($this->loadMore, Button::class, ['templateName' => 'load-more'])->getStyleSheets();
    }
}
