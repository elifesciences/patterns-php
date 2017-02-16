<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SectionListing implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $id;
    private $sections;
    private $singleLine;
    private $labelledBy;

    public function __construct(string $id, array $sections, bool $singleLine = false, string $labelledBy = null)
    {
        Assertion::notBlank($id);
        Assertion::allIsInstanceOf($sections, Link::class);
        Assertion::notEmpty($sections);

        $this->id = $id;
        $this->sections = $sections;
        $this->singleLine = $singleLine;
        $this->labelledBy = $labelledBy;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/section-listing.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/section-listing.mustache';
    }
}
