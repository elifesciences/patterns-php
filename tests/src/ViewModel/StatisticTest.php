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
        $expectedViewmodelStateAfterConstruction = ['label' => 'Downloads', 'value' => '2,034', 'shouldNotEscapeTerm'=>'true'];
        $constructedViewmodel = Statistic::fromNumber($expectedViewmodelStateAfterConstruction['label'], 2034, 'true');
        $this->assertSameValuesWithoutOrder($expectedViewmodelStateAfterConstruction, $constructedViewmodel->toArray());
    }

    /**
     * @test
     */
    public function it_has_data_via_its_fromString_method()
    {
        $expectedViewmodelStateAfterConstruction = ['label' => 'Downloads', 'value' => '2,034', 'shouldNotEscapeTerm'=>'true'];
        $constructedViewmodel = Statistic::fromString($expectedViewmodelStateAfterConstruction['label'], '2,034', 'true');
        $this->assertSameValuesWithoutOrder($expectedViewmodelStateAfterConstruction, $constructedViewmodel->toArray());
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
                Statistic::fromString('Downloads', '2,034'),
            ],
            'full from number' => [
                Statistic::fromNumber('Downloads', 2034),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/statistic.mustache';
    }
}
