<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContextualData;
use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\SpeechBubble;

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
                        'text' => 'foo',
                    ],
                ],
                'annotationCount' => [
                    'text' => '<span aria-hidden="true"><span data-visible-annotation-count>0</span></span><span class="visuallyhidden"> Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page).</span>',
                    'isSmall' => true,
                    'behaviour' => 'HypothesisOpener',
                ],
            ],
            'citation' => [
                'citeAs' => 'bar',
                'doi' => [
                    'doi' => '10.7554/eLife.10181.001',
                    'isTruncated' => true,
                ],
            ],
        ];

        $contextualData = ContextualData::withMetrics(['foo'], 'bar',
            new Doi('10.7554/eLife.10181.001'),
            SpeechBubble::forContextualData()
        );

        $this->assertSame($data['metricsData']['data'], $contextualData['metricsData']['data']);
        $this->assertSame($data['metricsData']['annotationCount'], $contextualData['metricsData']['annotationCount']->toArray());
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
            'hypothesis only' => [ContextualData::annotationsOnly(SpeechBubble::forContextualData())],
            'metrics minimum' => [ContextualData::withMetrics(['foo'])],
            'metrics complete' => [ContextualData::withMetrics(['foo'], 'bar', new Doi('10.7554/eLife.10181.001'), SpeechBubble::forContextualData())],
            'cite minimum' => [ContextualData::withCitation('foo', new Doi('10.7554/eLife.10181.001'))],
            'cite complete' => [ContextualData::withCitation('foo', new Doi('10.7554/eLife.10181.001'), ['bar'], SpeechBubble::forContextualData())],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/contextual-data.mustache';
    }
}
