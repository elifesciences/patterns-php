<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ListingProfileSnippets implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $seeMoreLink;
    private $heading;
    private $items;

    private function __construct(array $items, ListHeading $heading = null, SeeMoreLink $seeMoreLink = null)
    {
        Assertion::notEmpty($items);
        Assertion::allIsInstanceOf($items, ProfileSnippet::class);

        $this->seeMoreLink = $seeMoreLink;
        $this->heading = $heading;
        $this->items = $items;
    }

    public static function basic(array $items, $heading = null)
    {
        return new static ($items, $heading);
    }

    public static function withSeeMoreLink(array $items, SeeMoreLink $seeMoreLink, ListHeading $heading = null)
    {
        return new static($items, $heading, $seeMoreLink);
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/listing-profile-snippets.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/listing.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->items;
        yield $this->seeMoreLink;
        yield $this->heading;
    }
}
