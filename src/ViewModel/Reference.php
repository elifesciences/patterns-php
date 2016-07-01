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

    protected $abstracts;
    protected $authors;
    protected $origin;
    protected $secondaryLinkText;
    protected $title;
    protected $titleLink;
    protected $hasAuthors;
    protected $hasAbstracts;

    public function __construct(
        string $title,
        string $titleLink,
        string $origin,
        string $secondaryLinkText = '',
        array $authors = [],
        array $abstracts = []
    ) {
        Assertion::notBlank($title);
        Assertion::notBlank($titleLink);
        Assertion::notBlank($origin);
        Assertion::allIsInstanceOf($authors, Author::class);
        Assertion::allIsInstanceOf($abstracts, Link::class);

        $this->titleLink = $titleLink;
        $this->title = $title;
        $this->secondaryLinkText = $secondaryLinkText;
        $this->origin = $origin;
        $this->authors = $authors;
        $this->hasAuthors = !!$authors;
        $this->abstracts = $abstracts;
        $this->hasAbstracts = !!$abstracts;
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
