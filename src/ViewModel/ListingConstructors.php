<?php

namespace eLife\Patterns\ViewModel;

trait ListingConstructors
{
    public static function withSeeMore(array $items, SeeMoreLink $seeMoreLink, string $heading = null, string $id = null)
    {
        return new static($items, $id, $heading, null, $seeMoreLink);
    }

    public static function withPagination(array $items, Pager $pagination, $heading = null, string $id = null)
    {
        return new static($items, $id, $heading, $pagination);
    }

    public static function basic(array $items, $heading = null, string $id = null)
    {
        return new static ($items, $id, $heading);
    }
}
