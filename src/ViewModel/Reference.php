<?php

namespace eLife\Patterns\ViewModel;

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

    public function __construct(
        string $title,
        string $titleLink,
        string $secondaryLinkText,
        string $origin,
        array $authors = [],
        array $abstracts = []
    ) {
        $this->titleLink = $titleLink;
        $this->title = $title;
        $this->secondaryLinkText = $secondaryLinkText;
        $this->origin = $origin;
        $this->authors = $authors;
        $this->abstracts = $abstracts;
    }

    public function getInlineStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/reference.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/reference.mustache';
    }
}
