<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
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
        yield $this->primaryLinks->getStyleSheets();
        yield $this->secondaryLinks->getStyleSheets();
    }

    public function getInlineStyleSheets() : Traversable
    {
        yield $this->primaryLinks->getInlineStyleSheets();
        yield $this->secondaryLinks->getInlineStyleSheets();
    }

    public function getJavaScripts() : Traversable
    {
        yield $this->primaryLinks->getJavaScripts();
        yield $this->secondaryLinks->getJavaScripts();
    }

    public function getInlineJavaScripts() : Traversable
    {
        yield $this->primaryLinks->getInlineJavaScripts();
        yield $this->secondaryLinks->getInlineJavaScripts();
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/site-header.mustache';
    }

}
