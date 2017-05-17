<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class GridListing implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $classes;
    private $heading;
    private $blockLinks;
    private $imageLinks;
    private $archiveNavLinks;
    private $teasers;
    private $pagination;
    private $id;

    private function __construct(
        string $classes = null,
        string $heading = null,
        array $blockLinks = [],
        array $archiveNavLinks = [],
        array $imageLinks = [],
        array $teasers = [],
        Pager $pagination = null,
        string $id = null
    ) {
        $this->classes = $classes;
        $this->heading = $heading;
        $this->blockLinks = $blockLinks;
        $this->imageLinks = $imageLinks;
        $this->archiveNavLinks = $archiveNavLinks;
        $this->teasers = $teasers;
        $this->pagination = $pagination;
        $this->id = $id;
    }

    public static function forBlockLinks(array $blockLinks, string $heading = null) : GridListing
    {
        Assertion::notEmpty($blockLinks);
        Assertion::allIsInstanceOf($blockLinks, BlockLink::class);

        $blockLinks = array_map(function (BlockLink $blockLink) {
            $blockLink = FlexibleViewModel::fromViewModel($blockLink);

            return $blockLink->withProperty('isGridListing', true);
        }, $blockLinks);

        return new self('grid-listing--block-link', $heading, $blockLinks);
    }

    public static function forArchiveNavLinks(array $archiveNavLinks, string $heading = null) : GridListing
    {
        Assertion::notEmpty($archiveNavLinks);
        Assertion::allIsInstanceOf($archiveNavLinks, ArchiveNavLink::class);

        return new self(null, $heading, [], $archiveNavLinks);
    }

    public static function forImageLinks(array $imageLinks, string $heading = null) : GridListing
    {
        Assertion::notEmpty($imageLinks);
        Assertion::allIsInstanceOf($imageLinks, ImageLink::class);

        $imageLinks = array_map(function (ImageLink $imageLink) {
            $imageLink = FlexibleViewModel::fromViewModel($imageLink);

            return $imageLink->withProperty('variant', 'grid-listing');
        }, $imageLinks);

        return new self('grid-listing--image-link', $heading, [], [], $imageLinks);
    }

    public static function forTeasers(array $teasers, string $heading = null, Pager $pagination = null, string $id = null) : GridListing
    {
        Assertion::notEmpty($teasers);
        Assertion::allIsInstanceOf($teasers, Teaser::class);

        return new self(null, $heading, [], [], [], $teasers, $pagination, $id);
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/grid-listing.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->blockLinks;
        yield from $this->archiveNavLinks;
        yield from $this->teasers;
        yield $this->pagination;
    }
}
