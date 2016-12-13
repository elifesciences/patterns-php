<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class LoadMoreButton implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $classes;
    private $path;
    private $text;
    private $type;

    public function __construct(
        string $text,
        string $path,
        string $size = Button::SIZE_MEDIUM,
        string $style = Button::STYLE_DEFAULT,
        bool $isActive = true,
        bool $isFullWidth = false
    ) {
        $button = Button::link($text, $path, $size, $style, $isActive, $isFullWidth);
        $this->classes = $button['classes'];
        $this->path = $button['path'];
        $this->text = $button['text'];
        $this->type = $button['type'];
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/load-more.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/buttons.css';
        yield '/elife/patterns/assets/css/load-more.css';
    }
}
