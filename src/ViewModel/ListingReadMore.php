<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use InvalidArgumentException;
use Traversable;

final class ListingReadMore implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $items;
    private $id;
    private $heading;
    private $pagination;
    private $seeMoreLink;

    private function __construct(array $items, string $id = null, string $heading = null, Pager $pagination = null, SeeMoreLink $seeMoreLink = null)
    {
        if (
            null !== $pagination &&
            null !== $seeMoreLink
        ) {
            throw new InvalidArgumentException('You cannot have both Pager and SeeMoreLink in ReadMore Listings.');
        }
        Assertion::notEmpty($items);
        Assertion::allIsInstanceOf($items, ReadMoreItem::class);
        $this->items = $items;
        $this->id = $id;
        $this->heading = $heading;
        $this->pagination = $pagination;
        $this->seeMoreLink = $seeMoreLink;
    }

    public static function basic(array $items, $heading = null, string $id = null)
    {
        return new static ($items, $id, $heading);
    }

    public static function withPagination(array $items, Pager $pagination, $heading = null, string $id = null)
    {
        return new static($items, $id, $heading, $pagination);
    }

    public static function withSeeMore(array $items, SeeMoreLink $seeMoreLink, string $heading = null, string $id = null)
    {
        return new static($items, $id, $heading, null, $seeMoreLink);
    }

    protected function getComposedViewModels(): Traversable
    {
        yield from $this->items;
        yield $this->pagination;
    }

    public function getTemplateName(): string
    {
        return '/elife/patterns/templates/listing-read-more.mustache';
    }

    public function getLocalStyleSheets(): Traversable
    {
        yield '/elife/patterns/assets/css/listing.css';
    }
}
