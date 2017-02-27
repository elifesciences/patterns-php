<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class BarChart implements ViewModel
{
    use ComposedAssets;
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $id;
    private $type;
    private $containerId;
    private $apiEndpoint;
    private $daily;
    private $monthly;
    private $next;
    private $prev;
    private $metric;
    private $period;

    public function __construct(
        string $id,
        string $type,
        string $containerId,
        string $apiEndpoint,
        string $metric = null,
        string $period = null,
        Button $daily = null,
        Button $monthly = null,
        Picture $next = null,
        Picture $prev = null
    ) {
        Assertion::notBlank($id);
        Assertion::notBlank($type);
        Assertion::notBlank($containerId);
        Assertion::notBlank($apiEndpoint);

        $this->id = $id;
        $this->type = $type;
        $this->containerId = $containerId;
        $this->apiEndpoint = $apiEndpoint;
        $this->daily = $daily;
        $this->monthly = $monthly;
        $this->next = $next;
        $this->prev = $prev;
        $this->metric = $metric;
        $this->period = $period;
    }

    protected function getComposedViewModels(): Traversable
    {
        yield $this->daily;
        yield $this->monthly;
        yield $this->next;
        yield $this->prev;
    }

    public function getTemplateName(): string
    {
        return '/elife/patterns/templates/bar-chart.mustache';
    }

    public function getLocalStyleSheets(): Traversable
    {
        yield '/elife/patterns/assets/css/bar-chart.css';
    }
}
