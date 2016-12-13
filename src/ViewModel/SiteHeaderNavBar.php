<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SiteHeaderNavBar implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

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

            if ('search' === $linkedItems[$i]['rel']) {
                $classes[] = $classes[0].'--search';
            }

            $newLinkedItem = FlexibleViewModel::fromViewModel($linkedItems[$i])
                ->withProperty('classes', implode(' ', $classes));

            if (!empty($linkedItems[$i]['picture'])) {
                $textClasses = $newLinkedItem['textClasses'];

                $newLinkedItem = $newLinkedItem
                    ->withProperty('textClasses', trim($textClasses.' nav-'.$type.'__menu_text'));
            }

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

    protected function getLocalStyleSheets() : Traversable
    {
        if ('nav-primary' === $this->classesOuter) {
            yield '/elife/patterns/assets/css/site-header-nav-bar-primary.css';
        } else {
            yield '/elife/patterns/assets/css/site-header-nav-bar-secondary.css';
        }
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->linkedItems;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/site-header-nav-bar.mustache';
    }
}
