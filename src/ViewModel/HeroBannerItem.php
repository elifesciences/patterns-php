<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class HeroBannerItem implements ViewModel
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
        string $summary, array $subjects, Link $title, Authors $authors, Meta $meta, Image $image
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
        $this->authors = $authors;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/hero-banner-item.mustache';
    }
}
