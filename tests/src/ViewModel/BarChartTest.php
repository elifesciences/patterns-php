<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\BarChart;
use InvalidArgumentException;

final class BarChartTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'chart-id',
            'type' => 'article',
            'containerId' => 'chart-id-container',
            'apiEndpoint' => 'http://sub.api',
            'metric' => 'downloads',
            'period' => 'day',
        ];
        $model = new BarChart($data['id'], $data['type'], $data['containerId'], $data['apiEndpoint'].'/', $data['metric'], $data['period']);

        $this->assertSameValuesWithoutOrder($data, $model->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new BarChart('', 'type', 'containerId', 'http://example.com', BarChart::METRIC_DOWNLOADS);
    }

    /**
     * @test
     */
    public function it_must_have_a_type()
    {
        $this->expectException(InvalidArgumentException::class);

        new BarChart('id', '', 'containerId', 'http://example.com', BarChart::METRIC_DOWNLOADS);
    }

    /**
     * @test
     */
    public function it_must_have_a_container_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new BarChart('id', 'type', '', 'http://example.com', BarChart::METRIC_DOWNLOADS);
    }

    /**
     * @test
     */
    public function it_must_have_an_api_endpoint_uri()
    {
        $this->expectException(InvalidArgumentException::class);

        new BarChart('id', 'type', 'containerId', 'foo', BarChart::METRIC_DOWNLOADS);
    }

    /**
     * @test
     */
    public function it_must_have_a_valid_metric()
    {
        $this->expectException(InvalidArgumentException::class);

        new BarChart('id', 'type', 'containerId', 'http://example.com', 'foo');
    }

    /**
     * @test
     */
    public function it_must_have_a_valid_period()
    {
        $this->expectException(InvalidArgumentException::class);

        new BarChart('id', 'type', 'containerId', 'http://example.com', BarChart::METRIC_DOWNLOADS, 'foo');
    }

    public function viewModelProvider(): array
    {
        return [
            'full' => [
                new BarChart(
                    'chart-id',
                    'article',
                    'chart-id-container',
                    'http://sub.api/',
                    'downloads',
                    'month'
                ),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/bar-chart.mustache';
    }
}
