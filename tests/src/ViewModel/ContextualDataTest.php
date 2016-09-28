<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContextualData;
use eLife\Patterns\ViewModel\ContextualDataMetric;
use eLife\Patterns\ViewModel\Doi;

final class ContextualDataTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'metricsData' => [
                'data' => [
                    [
                        'name' => 'foo',
                        'elementId' => 'bar',
                        'value' => 'baz',
                    ],
                ],
            ],
            'citation' => [
                'citeAs' => 'qux',
                'doi' => [
                    'doi' => '10.7554/eLife.10181.001',
                ],
            ],
        ];

        $contextualData = ContextualData::withMetrics([new ContextualDataMetric('foo', 'bar', 'baz')], 'qux',
            new Doi('10.7554/eLife.10181.001'));

        $this->assertSame($data['metricsData']['data'][0], $contextualData['metricsData']['data'][0]->toArray());
        $this->assertSame($data['citation']['citeAs'], $contextualData['citation']['citeAs']);
        $this->assertSame($data['citation']['doi'], $contextualData['citation']['doi']->toArray());
        $this->assertSame($data, $contextualData->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'metrics only' => [ContextualData::withMetrics([new ContextualDataMetric('foo', 'bar', 'baz')])],
            'cite as only' => [ContextualData::withCitation('foo', new Doi('10.7554/eLife.10181.001'))],
            'both' => [
                ContextualData::withMetrics([new ContextualDataMetric('foo', 'bar', 'baz')], 'qux',
                    new Doi('10.7554/eLife.10181.001')),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/contextual-data.mustache';
    }
}
