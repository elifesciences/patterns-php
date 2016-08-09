<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;
use ArrayObject;

final class FilterPanel implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $title;
    private $filterGroups;
    private $button;

    public function __construct(string $title, array $filterGroups, Button $button)
    {
        Assertion::notBlank($title);
        Assertion::notEmpty($filterGroups);
        Assertion::allIsInstanceOf($filterGroups, FilterGroup::class);

        $this->title = $title;
        $this->filterGroups = $filterGroups;
        $this->button = $button;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/filter-panel.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/filter-panel.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->filterGroups;
    }
}
