<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\BarChart;
use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;

/**
 * @group failing
 */
class BarChartTest extends ViewModelTest
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
        ];
        $model = new BarChart($data['id'], $data['type'], $data['containerId'], $data['apiEndpoint']);

        $this->assertSameValuesWithoutOrder($data, $model->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            'basic' => [
                new BarChart('chart-id', 'article', 'chart-id-container', 'http://sub.api/'),
            ],
            'full' => [
                new BarChart(
                    'chart-id',
                    'article',
                    'chart-id-container',
                    'http://sub.api/',
                    'downloads',
                    'daily',
                    Button::form('Daily', 'button'),
                    Button::form('Monthly', 'button'),
                    new Picture([
                        [
                            'srcset' => 'http://d.com/next.svg',
                        ],
                    ], new Image('http://d.com/next.png')),
                    new Picture([
                        [
                            'srcset' => 'http://d.com/next.svg',
                        ],
                    ], new Image('http://d.com/prev.png'))
                ),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return '/elife/patterns/templates/bar-chart.mustache';
    }
}
