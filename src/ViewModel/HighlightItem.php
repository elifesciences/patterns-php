<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class HighlightItem implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $subjects;
    private $title;
    private $summary;
    private $authors;
    private $url;
    private $button;
    private $meta;
    private $image;

    public function __construct(array $subjects, Link $title, Meta $meta, Picture $image, string $summary, string $authors = null)
    {
        Assertion::allIsInstanceOf($subjects, Link::class);

        if (!empty($subjects)) {
            $this->subjects = ['list' => $subjects];
        }
        $this->title = $title['name'];
        $this->summary = $summary;
        $this->authors = $authors;
        $this->url = $title['url'];
        $this->meta = $meta;
        $this->image = $image;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/highlight-item.mustache';
    }
}
