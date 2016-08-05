<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use ReflectionClass;
use Traversable;

final class Listing implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    const PROFILE_SNIPPETS = 'isProfileSnippetType';
    const TEASERS = 'isTeaserType';

    private $seeMoreLink;
    private $loadMore;
    private $heading;
    private $items;

    private function __construct(string $heading, array $items, ListingItem $listingItem, string $typeProperty)
    {
        Assertion::notEmpty($items);
        Assertion::inArray($typeProperty, [self::PROFILE_SNIPPETS, self::TEASERS]);

        $this->{$typeProperty} = true;
        $this->{$listingItem->getProperty()} = $listingItem->getItem();
        $this->heading = $heading;
        $this->items = $items;
    }

    public static function withProfileSnippets($heading, ListingItem $listingItem, ProfileSnippet ...$items)
    {
        return new static($heading, $items, $listingItem, self::PROFILE_SNIPPETS);
    }

    public static function withTeasers($heading, ListingItem $listingItem, Teaser ...$items)
    {
        return new static($heading, $items, $listingItem, self::TEASERS);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/listing.mustache';
    }

    /**
     * @todo Slight technical debt here. I would maybe suggest making the get* methods static.
     *
     * @return Traversable
     */
    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/listing.css';
        yield from ((new ReflectionClass(ProfileSnippet::class))->newInstanceWithoutConstructor()->getStyleSheets());
        yield from ((new ReflectionClass(SeeMoreLink::class))->newInstanceWithoutConstructor()->getStyleSheets());
        yield from ((new ReflectionClass(Teaser::class))->newInstanceWithoutConstructor()->getStyleSheets());
        $ref = (new ReflectionClass(Button::class));
        $button = $ref->newInstanceWithoutConstructor();
        $prop = $ref->getProperty('templateName');
        $prop->setAccessible(true);
        $prop->setValue($button, 'load-more');
        yield from ($button->getStyleSheets());
    }
}
