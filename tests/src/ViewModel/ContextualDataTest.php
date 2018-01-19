<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContextualData;
use eLife\Patterns\ViewModel\ContextualDataMetric;
use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\HypothesisOpener;

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
                        'value' => 'bar',
                        'elementId' => 'baz',
                    ],
                ],
                "hypothesisOpener" => [
                    'button' => [
                        'classes' => 'button--speech-bubble',
                        'text' => '<span aria-hidden="true"><span data-visible-annotation-count>0</span> </span><span class="visuallyhidden">Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page). </span>',
                        'type' => 'button',
                    ],
                ],
            ],
            'citation' => [
                'citeAs' => 'qux',
                'doi' => [
                    'doi' => '10.7554/eLife.10181.001',
                    'isTruncated' => true,
                ],
            ],
        ];

        $contextualData = ContextualData::withMetrics([new ContextualDataMetric('foo', 'bar', 'baz')], 'qux',
            new Doi('10.7554/eLife.10181.001'),
            HypothesisOpener::forContextualData());

        $this->assertSame($data['metricsData']['data'][0], $contextualData['metricsData']['data'][0]->toArray());
        $this->assertSame($data['metricsData']['hypothesisOpener'], $contextualData['metricsData']['hypothesisOpener']->toArray());
        $this->assertSame($data['citation']['citeAs'], $contextualData['citation']['citeAs']);
        $this->assertSame($data['citation']['doi'], $contextualData['citation']['doi']->toArray());
        $this->assertSame($data, $contextualData->toArray());
    }

    /**
     * @test
     */
    public function it_truncates_doi()
    {
        $contextualData = ContextualData::withCitation('foo', new Doi('10.7554/eLife.10181.001'));
        $this->assertTrue($contextualData['citation']['doi']['isTruncated']);
    }

    public function viewModelProvider() : array
    {
        return [
            'metrics only' => [ContextualData::withMetrics([new ContextualDataMetric('foo', 'bar')])],
            'cite as only' => [ContextualData::withCitation('foo', new Doi('10.7554/eLife.10181.001'))],
            'both' => [
                ContextualData::withMetrics([new ContextualDataMetric('foo', 'bar', 'baz')], 'qux',
                    new Doi('10.7554/eLife.10181.001')),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/contextual-data.mustache';
    }
}
