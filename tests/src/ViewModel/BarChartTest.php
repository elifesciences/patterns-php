<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\BarChart;

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
            'apiEndpoint' => 'http://sub.api/',
            'metric' => 'downloads',
            'period' => 'day',
        ];
        $model = new BarChart($data['id'], $data['type'], $data['containerId'], $data['apiEndpoint'], $data['metric'], $data['period']);

        $this->assertSameValuesWithoutOrder($data, $model->toArray());
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
        return '/elife/patterns/templates/bar-chart.mustache';
    }
}
