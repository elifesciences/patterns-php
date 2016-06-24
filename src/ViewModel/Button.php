<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Button implements ViewModel
{
    const TYPE_BUTTON = 'button';
    const TYPE_SUBMIT = 'submit';
    const TYPE_RESET = 'reset';

    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $classes;
    private $path;
    private $text;
    private $type;

    private function __construct(string $text, array $classes = [])
    {
        Assertion::notBlank($text);

        $this->text = $text;
        $this->classes = implode(' ', $classes);
    }

    public static function form(string $text, string $type, array $classes = []) : Button
    {
        Assertion::choice($type, [self::TYPE_BUTTON, self::TYPE_SUBMIT, self::TYPE_RESET]);

        $button = new static($text, $classes);
        $button->type = $type;

        return $button;
    }

    public static function link(string $text, string $path, array $classes = []) : Button
    {
        Assertion::notBlank($path);

        $button = new static($text, $classes);
        $button->path = $path;

        return $button;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/button.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/buttons.css';
    }
}
