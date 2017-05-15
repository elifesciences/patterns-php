<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SectionListing implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $id;
    private $sections;
    private $listHeading;
    private $singleLine;
    private $labelledBy;

    public function __construct(string $id, array $sections, ListHeading $listHeading, bool $singleLine = false, string $labelledBy = null)
    {
        Assertion::notBlank($id);
        Assertion::allIsInstanceOf($sections, Link::class);
        Assertion::notEmpty($sections);

        $this->id = $id;
        $this->sections = $sections;
        $this->singleLine = $singleLine;
        $this->listHeading = $listHeading;
        $this->labelledBy = $labelledBy;
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/section-listing.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->listHeading;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/section-listing.mustache';
    }
}
