<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
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
    private $classes;
    private $img;
    private $path;
    private $rel;
    private $text;
    private $textClasses;

    private function __construct(array $classes = [])
    {
        Assertion::allString($classes);
        $this->classes = implode(' ', $classes);
    }

    public static function asLink(string $text, string $path, array $classes = [], array $textClasses = [],
                                  bool $search = false, PictureSvgWithFallback $img = null): NavLinkedItem
    {
        Assertion::notBlank($text);
        Assertion::notBlank($path);
        Assertion::allString($textClasses);

        $itemAsText = new static($classes);
        $itemAsText->text = $text;
        $itemAsText->path = $path;
        $itemAsText->textClasses = implode(' ', $textClasses);
        $itemAsText->rel = $search ? 'search' : null;
        $itemAsText->img = $img;

        return $itemAsText;
    }

    public static function asButton(Button $button, array $classes = []): NavLinkedItem
    {
        $itemAsButton = new static($classes);
        $itemAsButton->button = $button;

        return $itemAsButton;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/nav-linked-item.mustache';
    }
}
