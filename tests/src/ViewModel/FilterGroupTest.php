<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Filter;
use eLife\Patterns\ViewModel\FilterGroup;

final class FilterGroupTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'filterTitle' => 'title',
            'filters' => [
                    [
                        'isChecked' => true,
                        'label' => 'filter 1',
                    ],
                    [
                        'isChecked' => true,
                        'label' => 'filter 2',
                        'results' => 20,
                        'name' => 'some_name_20',
                    ],
                    [
                        'isChecked' => false,
                        'label' => 'filter 3',
                        'results' => 3000,
                        'name' => 'some_name_3000',
                        'value' => 'some value',
                    ],
                ],
        ];
        $filterGroup = new FilterGroup('title', [
            new Filter(
                $data['filters'][0]['isChecked'],
                $data['filters'][0]['label']
            ),
            new Filter(
                $data['filters'][1]['isChecked'],
                $data['filters'][1]['label'],
                $data['filters'][1]['results'],
                $data['filters'][1]['name']
            ),
            new Filter(
                $data['filters'][2]['isChecked'],
                $data['filters'][2]['label'],
                $data['filters'][2]['results'],
                $data['filters'][2]['name'],
                $data['filters'][2]['value']
            ),
        ], 'select-filter');

        $this->assertSame($data['filterTitle'], $filterGroup['filterTitle']);
        $this->assertSame($data['filters'][0]['label'], $filterGroup['filters'][0]['label']);
        $this->assertSame($data['filters'][1]['label'], $filterGroup['filters'][1]['label']);
        $this->assertSame($data['filters'][2]['label'], $filterGroup['filters'][2]['label']);
        $this->assertTrue($data['filters'][0]['isChecked']);
        $this->assertTrue($data['filters'][1]['isChecked']);
        $this->assertFalse($data['filters'][2]['isChecked']);
        $this->assertNull($filterGroup['filters'][0]['results']);
        $this->assertSame('20', $filterGroup['filters'][1]['results']);
        $this->assertSame('3,000', $filterGroup['filters'][2]['results']);
        $this->assertSame('select-filter', $filterGroup['isSelectFilter']);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new FilterGroup('title', [
                    new Filter(true, 'filter 1', '10', 'some_name_10'),
                    new Filter(true, 'filter 2', '20', 'some_name_20'),
                    new Filter(true, 'filter 3', '30', 'some_name_30'),
                ]),
                new FilterGroup('title', [
                    new Filter(true, 'filter 1'),
                    new Filter(true, 'filter 2', '20', 'some_name_20'),
                    new Filter(true, 'filter 3', '30', 'some_name_30'),
                ], 'select-filter'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/filter-group.mustache';
    }
}
