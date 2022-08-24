<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class HeroBanner implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $title;
    private $summary;
    private $authors;
    private $subjects;
    private $image;
    private $url;
    private $meta;

    public function __construct(
        string $summary, array $subjects, Link $title, string $authorLine, Meta $meta, Picture $image
    )
    {
        Assertion::notEmpty($title);
        if (!empty($subjects)) {
            $this->subjects = ['list' => $subjects];
        }
        $this->summary = $summary;
        $this->title = $title['name'];
        $this->url = $title['url'];
        $this->meta = $meta;
        $this->image = $image;
        $this->authors = $authorLine;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/hero-banner.mustache';
    }
}
