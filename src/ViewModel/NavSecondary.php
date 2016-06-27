<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class NavSecondary implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $navSecondaryLinks;

    public function __construct(array $linkedItems)
    {
        Assertion::allIsInstanceOf($linkedItems, NavLinkedItem::class);
        $this->navSecondaryLinks = $linkedItems;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/nav-secondary.css';
        yield $this->navSecondaryLinks[0]->getStyleSheets();
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/nav-secondary.mustache';
    }
}
