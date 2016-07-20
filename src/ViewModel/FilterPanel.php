<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class FilterPanel implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $title;
    private $filterGroups;
    private $button;

    public function __construct(string $title, array $filterGroups, Button $button)
    {
        Assertion::notBlank($title);
        Assertion::allIsInstanceOf($filterGroups, FilterGroup::class);

        $this->title = $title;
        $this->filterGroups = $filterGroups;
        $this->button = $button;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/filter-panel.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/filter-panel.css';
        yield array_map(function (FilterGroup $filter) {
            yield $filter->getStyleSheets();
        }, $this->filterGroups);
    }
}
