<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SiteHeaderNavBar implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $classesInner;
    private $classesOuter;
    private $linkedItems;

    private function __construct(array $linkedItems)
    {
        Assertion::allIsInstanceOf($linkedItems, NavLinkedItem::class);
        Assertion::notEmpty($linkedItems);
        $this->linkedItems = $linkedItems;
    }

    public static function primary(array $linkedItems) : SiteHeaderNavBar
    {
        $primaryNavBar = new static($linkedItems);
        $primaryNavBar->classesOuter = 'nav-primary';
        $primaryNavBar->classesInner = 'nav-primary__list clearfix';

        return $primaryNavBar;
    }

    public static function secondary(array $linkedItems) : SiteHeaderNavBar
    {
        $secondaryNavBar = new static($linkedItems);
        $secondaryNavBar->classesOuter = 'nav-secondary';
        $secondaryNavBar->classesInner = 'nav-secondary__list clearfix';

        return $secondaryNavBar;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/site-header-nav-bar-primary.css';
        yield '/elife/patterns/assets/css/site-header-nav-bar-secondary.css';
        yield $this->linkedItems[0]->getStyleSheets();
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/site-header-nav-bar.mustache';
    }
}
