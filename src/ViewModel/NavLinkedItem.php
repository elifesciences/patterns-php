<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class NavLinkedItem implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    const ICON_CLASSES = [
        'menu' => 'nav-primary__menu_icon',
        'search' => 'nav-primary__search_icon',
    ];

    private $button;
    private $picture;
    private $path;
    private $rel;
    private $text;
    private $textClasses;

    private function __construct()
    {
    }

    public static function asIcon(
        Link $link,
        Picture $picture,
        bool $showText = true,
        bool $search = false,
        string $iconName = null
    ): NavLinkedItem {
        $itemAsIcon = static::asLink($link, $search);

        $itemAsIcon->picture = $itemAsIcon->determinePicture($picture, $iconName);

        if (false === $showText) {
            $itemAsIcon->textClasses = 'visuallyhidden';
        }

        return $itemAsIcon;
    }

    public static function asLink(
        Link $link,
        bool $search = false
    ): NavLinkedItem {
        $itemAsText = new static();
        $itemAsText->text = $link['name'];
        $itemAsText->path = $link['url'];
        $itemAsText->rel = $search ? 'search' : null;

        return $itemAsText;
    }

    public static function asButton(Button $button): NavLinkedItem
    {
        $itemAsButton = new static();
        $itemAsButton->button = $button;

        return $itemAsButton;
    }

    private function determinePicture(Picture $picture, string $iconName = null)  : ViewModel
    {
        if (!array_key_exists($iconName, static::ICON_CLASSES)) {
            return $picture;
        }

        $picture = FlexibleViewModel::fromViewModel($picture);

        $fallback = $picture['fallback'];
        $fallback['classes'] = static::ICON_CLASSES[$iconName];

        return $picture->withProperty('fallback', $fallback);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/nav-linked-item.mustache';
    }
}
