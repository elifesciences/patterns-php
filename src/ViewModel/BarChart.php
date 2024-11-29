<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class BarChart implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    public const METRIC_DOWNLOADS = 'downloads';
    public const METRIC_PAGE_VIEWS = 'page-views';
    public const PERIOD_DAY = 'day';
    public const PERIOD_MONTH = 'month';

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
        string $period = self::PERIOD_MONTH
    ) {
        Assertion::notBlank($id);
        Assertion::choice($type, ['article']);
        Assertion::notBlank($containerId);
        Assertion::url($apiEndpoint);
        Assertion::choice($metric, [self::METRIC_DOWNLOADS, self::METRIC_PAGE_VIEWS]);
        Assertion::choice($period, [self::PERIOD_DAY, self::PERIOD_MONTH]);

        $this->id = $id;
        $this->type = $type;
        $this->containerId = $containerId;
        $this->apiEndpoint = rtrim($apiEndpoint, '/');
        $this->metric = $metric;
        $this->period = $period;
    }

    public function getTemplateName(): string
    {
        return 'resources/templates/bar-chart.mustache';
    }
}
