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

    public function __construct(string $filterTitle, array $filters)
    {
        Assertion::notBlank($filterTitle);
        Assertion::allIsInstanceOf($filters, Filter::class);

        $this->filterTitle = $filterTitle;
        $this->filters = $filters;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/filter-group.mustache';
    }
}
