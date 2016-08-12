<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class ListingProfileSnippets implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $seeMoreLink;
    private $heading;
    private $items;

    private function __construct(array $items, string $heading = null, SeeMoreLink $seeMoreLink = null)
    {
        $this->seeMoreLink = $seeMoreLink;
        $this->heading = $heading;
        $this->items = $items;
    }

    public static function basic(ProfileSnippet ...$items)
    {
        return new static ($items);
    }

    public static function withHeading(string $heading, SeeMoreLink $seeMoreLink, ProfileSnippet ...$items)
    {
        return new static($items, $heading, $seeMoreLink);
    }

    public static function withoutHeading(SeeMoreLink $seeMoreLink, ProfileSnippet ...$items)
    {
        return new static($items, null, $seeMoreLink);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/listing-profile-snippets.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/listing.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->items;
        yield $this->seeMoreLink;
    }
}
