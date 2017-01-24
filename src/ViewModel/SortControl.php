<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SortControl implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $options;

    public function __construct(array $options)
    {
        Assertion::notEmpty($options);
        Assertion::allIsInstanceOf($options, SortControlOption::class);

        $this->options = $options;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/sort-control.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/sort-control.css';
    }
}
