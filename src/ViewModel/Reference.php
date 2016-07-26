<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Reference implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $abstracts;
    private $authors;
    private $origin;
    private $secondaryLinkText;
    private $title;
    private $titleLink;
    private $hasAuthors;
    private $hasAbstracts;

    public function __construct(
        string $title,
        string $origin,
        string $titleLink = null,
        string $secondaryLinkText = null,
        array $authors = [],
        array $abstracts = []
    ) {
        Assertion::notBlank($title);
        Assertion::notBlank($origin);
        Assertion::allIsInstanceOf($authors, Author::class);
        Assertion::allIsInstanceOf($abstracts, Link::class);

        $this->titleLink = $titleLink;
        $this->title = $title;
        $this->secondaryLinkText = $secondaryLinkText;
        $this->origin = $origin;
        $this->authors = $authors;
        $this->hasAuthors = !empty($authors);
        $this->abstracts = $abstracts;
        $this->hasAbstracts = !empty($abstracts);
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/reference.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/reference.mustache';
    }
}
