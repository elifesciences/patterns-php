<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Statistic;

class StatisticTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = ['label' => 'Downloads', 'value' => '2,034'];
        $model = Statistic::fromNumber($data['label'], 2034);
        $this->assertSameValuesWithoutOrder($data, $model->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [
                Statistic::fromString('Downloads', '2,034'),
            ],
            'minimum from number' => [
                Statistic::fromNumber('Downloads', 2034),
            ],
            'full' => [
                Statistic::fromString('Downloads', '2,034', 'text'),
            ],
            'full from number' => [
                Statistic::fromNumber('Downloads', 2034, 'text'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/statistic.mustache';
    }
}
