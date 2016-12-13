<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class FilterGroup implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $title;
    private $filters;

    public function __construct(string $title, array $filters)
    {
        Assertion::notBlank($title);
        Assertion::allIsInstanceOf($filters, Filter::class);

        $this->title = $title;
        $this->filters = $filters;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/filter-group.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/filter-group.css';
    }
}
