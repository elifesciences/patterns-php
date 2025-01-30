<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class FilterGroup implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $filterTitle;
    private $filters;
    private $isSelectFilter;

    public function __construct(string $filterTitle = null, array $filters, string $isSelectFilter = null)
    {
        Assertion::nullOrNotBlank($filterTitle);
        Assertion::allIsInstanceOf($filters, Filter::class);
        Assertion::nullOrNotBlank($isSelectFilter);

        $this->filterTitle = $filterTitle;
        $this->filters = $filters;
        $this->isSelectFilter = $isSelectFilter;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/filter-group.mustache';
    }
}
