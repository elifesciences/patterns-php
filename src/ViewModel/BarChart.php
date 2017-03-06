<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class BarChart implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $id;
    private $type;
    private $containerId;
    private $apiEndpoint;
    private $metric;
    private $period;

    public function __construct(
        string $id,
        string $type,
        string $containerId,
        string $apiEndpoint,
        string $metric,
        string $period
    ) {
        Assertion::notBlank($id);
        Assertion::notBlank($type);
        Assertion::notBlank($containerId);
        Assertion::notBlank($apiEndpoint);

        $this->id = $id;
        $this->type = $type;
        $this->containerId = $containerId;
        $this->apiEndpoint = $apiEndpoint;
        $this->metric = $metric;
        $this->period = $period;
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
