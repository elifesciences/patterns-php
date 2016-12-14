<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class CarouselItem implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $subjects;
    private $name;
    private $url;
    private $button;
    private $meta;

    public function __construct(array $subjects, Link $title, string $buttonText = null, Meta $meta)
    {
        Assertion::allIsInstanceOf($subjects, Link::class);

        if (!empty($subjects)) {
            $this->subjects = ['list' => $subjects];
        }
        $this->name = $title['name'];
        $this->url = $title['url'];
        if ($buttonText) {
            $this->button = Button::link($buttonText, $this->url, Button::SIZE_MEDIUM, Button::STYLE_OUTLINE);
        }
        $this->meta = $meta;
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/carousel-item.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/carousel-item.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->button;
        yield $this->meta;
    }
}
