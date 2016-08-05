<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ReferenceList implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $references;

    public function __construct(ReferenceListItem ...$references)
    {
        Assertion::notEmpty($references);

        $this->references = $references;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/reference-list.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/reference-list.css';
    }
}
