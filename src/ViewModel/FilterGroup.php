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

    private $title;
    private $filters;

    public function __construct(string $title, array $filters)
    {
        Assertion::notBlank($title);
        Assertion::allIsInstanceOf($filters, Filter::class);

        $this->title = $title;
        $this->filters = $filters;
    }

    public function getTemplateName(): string
    {
        return 'resources/templates/filter-group.mustache';
    }
}
