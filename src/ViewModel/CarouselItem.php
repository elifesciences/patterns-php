<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class CarouselItem implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $subjects;
    private $title;
    private $longTitle;
    private $url;
    private $button;
    private $meta;
    private $image;

    public function __construct(array $subjects, Link $title, string $buttonText = null, Meta $meta, Picture $image)
    {
        Assertion::allIsInstanceOf($subjects, Link::class);

        if (!empty($subjects)) {
            $this->subjects = ['list' => $subjects];
        }
        $this->title = $title['name'];
        if (strlen(strip_tags($this->title)) >= 20) {
            $this->longTitle = true;
        }
        $this->url = $title['url'];
        if ($buttonText) {
            $this->button = Button::link($buttonText, $this->url, Button::SIZE_SMALL, Button::STYLE_OUTLINE);
        }
        $this->meta = $meta;
        $this->image = $image;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/carousel-item.mustache';
    }
}
