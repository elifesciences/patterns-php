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
    use ListingConstructors;
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $allRelated;
    private $items;
    private $id;
    private $heading;
    private $pagination;
    private $seeMoreLink;

    private function __construct(array $items, string $id = null, ListHeading $heading = null, Pager $pagination = null, SeeMoreLink $seeMoreLink = null)
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
        $this->seeMoreLink = $seeMoreLink;
        $this->heading = $heading;
        $this->pagination = $pagination;
        $this->id = $id;
        $this->allRelated = $this->areAllRelated($items);
    }

    private function areAllRelated(array $items) : bool
    {
        foreach ($items as $item) {
            if (!$item['isRelated']) {
                return false;
            }
        }

        return true;
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->items;
        yield $this->pagination;
        yield $this->heading;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/listing-read-more.mustache';
    }
}
