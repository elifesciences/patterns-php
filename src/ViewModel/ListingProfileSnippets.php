<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class ListingProfileSnippets implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $seeMoreLink;
    private $heading;
    private $items;

    private function __construct(string $heading = null, SeeMoreLink $seeMoreLink, $items)
    {
        $this->seeMoreLink = $seeMoreLink;
        $this->heading = $heading;
        $this->items = $items;
    }

    public static function withHeading(string $heading, SeeMoreLink $seeMoreLink, ProfileSnippet ...$items)
    {
        return new static($heading, $seeMoreLink, $items);
    }

    public static function withoutHeading(SeeMoreLink $seeMoreLink, ProfileSnippet ...$items)
    {
        return new static(null, $seeMoreLink, $items);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/listing-profile-snippets.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/listing.css';
        yield from $this->seeMoreLink->getStyleSheets();
        yield from $this->items[0]->getStyleSheets();
    }
}
