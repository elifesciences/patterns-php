<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Filter;
use eLife\Patterns\ViewModel\FilterGroup;

class FilterGroupTest extends ViewModelTest
{

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'title',
            'filters' =>
                [
                    [
                        'isChecked' => true,
                        'label' => 'filter 1',
                        'results' => '10',
                    ],
                    [
                        'isChecked' => true,
                        'label' => 'filter 2',
                        'results' => '20',
                    ],
                    [
                        'isChecked' => false,
                        'label' => 'filter 3',
                        'results' => '30',
                    ],
                ],
        ];
        $filterGroup = new FilterGroup('title', [
            new Filter($data['filters'][0]['isChecked'], $data['filters'][0]['label'], $data['filters'][0]['results']),
            new Filter($data['filters'][1]['isChecked'], $data['filters'][1]['label'], $data['filters'][1]['results']),
            new Filter($data['filters'][2]['isChecked'], $data['filters'][2]['label'], $data['filters'][2]['results']),
        ]);

        $this->assertSame($data['title'], $filterGroup['title']);
        foreach ($filterGroup['filters'] as $k => $filter) {
            $this->assertSame($data['filters'][$k], $filterGroup['filters'][$k]->toArray());
        }
        $this->assertSame($data, $filterGroup->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new FilterGroup('title', [
                    new Filter(true, 'filter 1', '10'),
                    new Filter(true, 'filter 2', '20'),
                    new Filter(true, 'filter 3', '30'),
                ])
            ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/filter-group.mustache';
    }
}
