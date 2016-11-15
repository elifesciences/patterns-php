<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class Reference implements ViewModel
{
    use ArrayFromProperties;
    use ComposedAssets;
    use ReadOnlyArrayAccess;

    private $abstracts;
    private $authorLists;
    private $origin;
    private $doi;
    private $title;
    private $titleLink;
    private $hasAuthors;
    private $hasAbstracts;

    private function __construct(
        string $title,
        string $origin = null,
        string $titleLink = null,
        Doi $doi = null,
        array $authorLists = [],
        array $abstracts = []
    ) {
        Assertion::notBlank($title);
        Assertion::allIsInstanceOf($authorLists, ReferenceAuthorList::class);
        Assertion::allIsInstanceOf($abstracts, Link::class);

        $this->titleLink = $titleLink;
        $this->title = $title;
        $this->doi = $doi;
        $this->origin = $origin;
        $this->authorLists = $authorLists;
        $this->hasAuthors = !empty($authorLists);
        $this->abstracts = $abstracts;
        $this->hasAbstracts = !empty($abstracts);
    }

    public static function withDoi(
        string $title,
        Doi $doi,
        string $origin = null,
        array $authorLists = [],
        array $abstracts = []
    ) : Reference {
        return new self($title, $origin, null, $doi, $authorLists, $abstracts);
    }

    public static function withOutDoi(
        Link $title,
        string $origin = null,
        array $authorLists = [],
        array $abstracts = []
    ) : Reference {
        return new self($title['name'], $origin, $title['url'], null, $authorLists, $abstracts);
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/reference.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->doi;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/reference.mustache';
    }
}
