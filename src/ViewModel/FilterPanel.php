<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class FilterPanel implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $title;
    private $filterGroups;
    private $button;
    private $name;
    private $value;

    public function __construct(
        string $title,
        array $filterGroups,
        Button $button,
        string $name,
        string $value = null
    ) {
        Assertion::notBlank($title);
        Assertion::notEmpty($filterGroups);
        Assertion::allIsInstanceOf($filterGroups, FilterGroup::class);

        $this->title = $title;
        $this->filterGroups = $filterGroups;
        $this->button = $button;
        $this->name = $name;
        $this->value = $value;
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
