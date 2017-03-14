<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class StatisticCollection implements ViewModel
{
    use ComposedAssets;
    use ArrayFromProperties;
    use ArrayAccessFromProperties;

    private $stats;

    public function __construct(Statistic ...$stats)
    {
        Assertion::notEmpty($stats);

        $this->stats = $stats;
    }

    protected function getLocalStyleSheets(): Traversable
    {
        yield 'resources/assets/css/statistic-collection.css';
    }

    protected function getComposedViewModels(): Traversable
    {
        yield from $this->stats;
    }

    public function getTemplateName(): string
    {
        return 'resources/templates/statistic-collection.mustache';
    }
}
