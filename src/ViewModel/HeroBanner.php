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
    private $content;
    private $date;
    private $authors;
    private $topic;
    private $image;

    public function __construct($title, $content, $date, $authors, $topic, $image)
    {
        Assertion::notEmpty($title);
        $this->title = $title;
        $this->content = $content;
        $this->date = $date;
        $this->authors = $authors;
        $this->topic = $topic;
        $this->image = $image;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/hero-banner.mustache';
    }
}
