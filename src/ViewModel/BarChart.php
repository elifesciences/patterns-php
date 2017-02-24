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
    private $monthlyId;
    private $dailyId;
    private $daily;
    private $monthly;
    private $next;
    private $prev;

    public function __construct(
        string $id,
        string $type,
        string $containerId,
        string $apiEndpoint,
        string $monthlyId = null,
        string $dailyId = null,
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
        $this->monthlyId = $monthlyId;
        $this->dailyId = $dailyId;
        $this->daily = $daily;
        $this->monthly = $monthly;
        $this->next = $next;
        $this->prev = $prev;
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
