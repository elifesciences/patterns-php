<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class NavPrimary implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $navPrimaryLinks;

    public function __construct(array $linkedItems)
    {
        Assertion::allIsInstanceOf($linkedItems, NavLinkedItem::class);
        $this->navPrimaryLinks = $linkedItems;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/nav-primary.css';
        yield $this->navPrimaryLinks[0]->getStyleSheets();
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/nav-primary.mustache';
    }
}
