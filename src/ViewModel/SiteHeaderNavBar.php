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
    private $linkedItems = [];

    private function __construct(array $linkedItems, string $type)
    {
        Assertion::allIsInstanceOf($linkedItems, NavLinkedItem::class);
        Assertion::notEmpty($linkedItems);

        $linkedItems = array_values($linkedItems);

        for ($i = 0; $i < count($linkedItems); ++$i) {
            $classes = ['nav-'.$type.'__item'];

            if (0 === $i) {
                $classes[] = $classes[0].'--first';
            }
            if ((count($linkedItems) - 1) === $i) {
                $classes[] = $classes[0].'--last';
            }

            $newLinkedItem = FlexibleViewModel::fromViewModel($linkedItems[$i])
                ->withProperty('classes', implode(' ', $classes));

            $this->linkedItems[] = $newLinkedItem;
        }

        $this->classesOuter = 'nav-'.$type;
        $this->classesInner = 'nav-'.$type.'__list clearfix';
    }

    public static function primary(array $linkedItems) : SiteHeaderNavBar
    {
        return new static($linkedItems, 'primary');
    }

    public static function secondary(array $linkedItems) : SiteHeaderNavBar
    {
        return new static($linkedItems, 'secondary');
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
