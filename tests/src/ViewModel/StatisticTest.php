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

    public function viewModelProvider(): array
    {
        return [
            'minimum' => [
                Statistic::fromString('Downloads', '2,034'),
            ],
            'minimum from number' => [
                Statistic::fromNumber('Downloads', 2034),
            ],
            'full' => [
                Statistic::fromString('Downloads', '2,034', 'some--modifier'),
            ],
            'full from number' => [
                Statistic::fromNumber('Downloads', 2034, 'some--modifier'),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return '/elife/patterns/templates/statistic.mustache';
    }
}
