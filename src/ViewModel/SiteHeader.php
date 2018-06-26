<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;
use Traversable;

final class SiteHeader implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $homePagePath;
    private $primaryLinks;
    private $secondaryLinks;
    private $searchBox;

    public function __construct(string $homePagePath, SiteHeaderNavBar $primaryLinks, SiteHeaderNavBar $secondaryLinks, SearchBox $searchBox = null)
    {
        Assertion::notBlank($homePagePath);

        $this->homePagePath = $homePagePath;
        $this->primaryLinks = $primaryLinks;
        $this->secondaryLinks = $secondaryLinks;
        if ($searchBox) {
            $this->searchBox = FlexibleViewModel::fromViewModel($searchBox)->withProperty('inContentHeader', true);
        }
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->primaryLinks;
        yield $this->secondaryLinks;
        yield $this->searchBox;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/site-header.mustache';
    }
}
