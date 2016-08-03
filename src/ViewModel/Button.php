<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ListingItem;
use eLife\Patterns\MultipleTemplates;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class Button implements ViewModel
{
    const SIZE_MEDIUM = 'medium';
    const SIZE_SMALL = 'small';
    const SIZE_EXTRA_SMALL = 'extra-small';

    const STYLE_DEFAULT = 'default';
    const STYLE_OUTLINE = 'outline';

    const TYPE_BUTTON = 'button';
    const TYPE_SUBMIT = 'submit';
    const TYPE_RESET = 'reset';

    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;
    use MultipleTemplates;

    private $classes;
    private $path;
    private $text;
    private $type;

    private function __construct(string $text, string $size, string $style, bool $isActive, bool $isFullWidth = true)
    {
        Assertion::notBlank($text);
        Assertion::choice($size, [self::SIZE_MEDIUM, self::SIZE_SMALL, self::SIZE_EXTRA_SMALL]);
        Assertion::choice($style, [self::STYLE_DEFAULT, self::STYLE_OUTLINE]);

        $classes = [];

        if (self::SIZE_MEDIUM !== $size) {
            $classes[] = 'button--'.$size;
        }

        if (self::STYLE_OUTLINE === $style && false === $isActive) {
            $classes[] = 'button--outline-inactive';
        } else {
            $classes[] = 'button--'.$style;

            if (false === $isActive) {
                $classes[] = 'button--inactive';
            }
        }

        if (true === $isFullWidth) {
            $classes[] = 'button--full';
        }

        $this->text = $text;
        $this->classes = implode(' ', $classes);
    }

    public static function form(
        string $text,
        string $type,
        string $size = self::SIZE_MEDIUM,
        string $style = self::STYLE_DEFAULT,
        bool $isActive = true,
        bool $isFullWidth = false
    ) : Button {
        Assertion::choice($type, [self::TYPE_BUTTON, self::TYPE_SUBMIT, self::TYPE_RESET]);

        $button = new static($text, $size, $style, $isActive, $isFullWidth);
        $button->type = $type;

        return $button;
    }

    public static function loadMoreLink(
        string $text,
        string $path,
        string $size = self::SIZE_MEDIUM,
        string $style = self::STYLE_DEFAULT,
        bool $isActive = true,
        bool $isFullWidth = false
    ) : Button {
        Assertion::allNotNull([ $text, $size, $style, $isActive, $isFullWidth ]);
        Assertion::notBlank($path);
        $button = new class($text, $size, $style, $isActive, $isFullWidth) extends Button implements ListingItem
        // This is a PHP-CS-Fixer bug.
 {
 };
        $button->setTemplateName('load-more');
        $button->path = $path;

        return $button;
    }

    public static function link(
        string $text,
        string $path,
        string $size = self::SIZE_MEDIUM,
        string $style = self::STYLE_DEFAULT,
        bool $isActive = true,
        bool $isFullWidth = false
    ) : Button {
        Assertion::notBlank($path);

        $button = new static($text, $size, $style, $isActive, $isFullWidth);
        $button->path = $path;

        return $button;
    }

    public function getDefaultTemplateName() : string
    {
        return '/elife/patterns/templates/button.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/buttons.css';
        if ($this->templateName) {
            yield '/elife/patterns/assets/css/'.$this->templateName.'.css';
        }
    }
}
