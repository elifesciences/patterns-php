<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class SiteHeader implements ViewModel
{
    use ArrayFromProperties;
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

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/site-header.css';
        yield from $this->primaryLinks->getStyleSheets();
        yield from $this->secondaryLinks->getStyleSheets();
    }

    public function getJavaScripts() : Traversable
    {
        yield from $this->primaryLinks->getJavaScripts();
        yield from $this->secondaryLinks->getJavaScripts();
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/site-header.mustache';
    }
}
