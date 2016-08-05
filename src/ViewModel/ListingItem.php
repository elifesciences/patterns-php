<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;

final class ListingItem
{
    const SEE_MORE_LINK = 'seeMoreLink';
    const LOAD_MORE_LINK = 'loadMore';

    private $seeMoreLink;
    private $button;
    private $property;

    protected function __construct(string $property, SeeMoreLink $seeMoreLink = null, Button $button = null)
    {
        Assertion::inArray($property, [self::SEE_MORE_LINK, self::LOAD_MORE_LINK]);

        $this->seeMoreLink = $seeMoreLink;
        $this->button = $button;
        $this->property = $property;
    }

    public function getItem()
    {
        return (null !== $this->button) ? $this->button : $this->seeMoreLink;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public static function asSeeMoreLink(SeeMoreLink $seeMoreLink)
    {
        return new static (self::SEE_MORE_LINK, $seeMoreLink);
    }

    public static function asLoadMoreLink(Button $button)
    {
        Assertion::true($button['templateName'] === 'load-more');

        return new static (self::LOAD_MORE_LINK, null, $button);
    }
}
