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

    private $button;
    private $img;
    private $path;
    private $rel;
    private $text;
    private $textClasses;

    private function __construct()
    {
    }

    public static function asIcon(
      Link $link,
      Picture $img,
      bool $showText = true,
      bool $search = false
    ): NavLinkedItem {
        $itemAsIcon = static::asLink($link, $search);
        $itemAsIcon->img = $img;
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

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/nav-linked-item.mustache';
    }
}
