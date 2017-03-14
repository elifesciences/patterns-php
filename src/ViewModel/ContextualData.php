<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ContextualData implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $metricsData;
    private $citation;

    private function __construct(array $metrics, string $citeAs = null, Doi $doi = null)
    {
        Assertion::allIsInstanceOf($metrics, ContextualDataMetric::class);

        if ($metrics) {
            $this->metricsData = ['data' => $metrics];
        }

        if ($citeAs && $doi) {
            $doi = FlexibleViewModel::fromViewModel($doi);
            $this->citation = [
                'citeAs' => $citeAs,
                'doi' => $doi->withProperty('isTruncated', true),
            ];
        }
    }

    public static function withMetrics(array $metrics, string $citeAs = null, Doi $doi = null) : ContextualData
    {
        Assertion::notEmpty($metrics);

        return new self($metrics, $citeAs, $doi);
    }

    public static function withCitation(string $citeAs, Doi $doi, array $metrics = []) : ContextualData
    {
        Assertion::notBlank($citeAs);

        return new self($metrics, $citeAs, $doi);
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/contextual-data.mustache';
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/contextual-data.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        if ($this->citation) {
            yield $this->citation['doi'];
        }
    }
}
