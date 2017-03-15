<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Statistic;
use eLife\Patterns\ViewModel\StatisticCollection;
use InvalidArgumentException;

class StatisticCollectionTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'stats' => [
                [
                    'label' => 'label',
                    'value' => '1,000',
                ],

                [
                    'label' => 'label',
                    'value' => '2,000',
                ],
            ],
        ];
        $model = new StatisticCollection(...array_map(function ($stat) {
            return Statistic::fromString($stat['label'], $stat['value']);
        }, $data['stats']));

        $this->assertSameValuesWithoutOrder($data, $model->toArray());
    }

    /**
     * @test
     */
    public function is_should_fail_when_empty()
    {
        $this->expectException(InvalidArgumentException::class);

        new StatisticCollection();
    }

    public function viewModelProvider(): array
    {
        return [
          'minimum' => [
              new StatisticCollection(Statistic::fromString('label', '1,234')),
          ],
          'full' => [
              new StatisticCollection(
                  Statistic::fromString('label', '1,234'),
                  Statistic::fromNumber('label', 1234)
              ),
          ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/statistic-collection.mustache';
    }
}
