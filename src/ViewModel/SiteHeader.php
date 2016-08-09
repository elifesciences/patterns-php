<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class SiteHeader implements ViewModel
{
    use ArrayFromProperties;
    use ComposedAssets;
    use ReadOnlyArrayAccess;

    private $homePagePath;
    private $primaryLinks;
    private $secondaryLinks;

    public function __construct(string $homePagePath, SiteHeaderNavBar $primaryLinks, SiteHeaderNavBar $secondaryLinks)
    {
        Assertion::notBlank($homePagePath);

        $this->homePagePath = $homePagePath;
        $this->primaryLinks = $primaryLinks;
        $this->secondaryLinks = $secondaryLinks;
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/site-header.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->primaryLinks;
        yield $this->secondaryLinks;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/site-header.mustache';
    }
}
