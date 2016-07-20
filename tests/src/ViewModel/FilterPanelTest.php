<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel;
use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\Filter;
use eLife\Patterns\ViewModel\FilterGroup;
use eLife\Patterns\ViewModel\FilterPanel;

class FilterPanelTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'Search results',
            'filterGroups' => [
                    [
                        'title' => 'title',
                        'filters' => [
                                [
                                    'isChecked' => true,
                                    'label' => 'something',
                                    'results' => '10',
                                ],
                                [
                                    'isChecked' => true,
                                    'label' => 'something',
                                    'results' => '100',
                                ],
                                [
                                    'isChecked' => true,
                                    'label' => 'something',
                                    'results' => '1,000',
                                ],
                            ],
                    ],
                ],
            'button' => [
                    'classes' => 'button--small button--default',
                    'text' => 'search',
                    'type' => 'submit',
                ],
        ];
        $panel = new FilterPanel('Search results', [
            new FilterGroup('title', [
                new Filter(true, 'something', 10),
                new Filter(true, 'something', 100),
                new Filter(true, 'something', 1000),
            ]),
        ], Button::form('search', 'submit', Button::SIZE_SMALL));

        $this->assertSame($data['title'], $panel['title']);
        $this->assertSame($data['filterGroups'], $this->allToArray($panel['filterGroups']));
        $this->assertSame($data['button'], $panel['button']->toArray());
        $this->assertSame($data, $panel->toArray());
    }

    private function allToArray(array $all) : array
    {
        return array_map(
            function (ViewModel $a) {
                return $a->toArray();
            },
            $all
        );
    }

    public function viewModelProvider() : array
    {
        return [
            [new FilterPanel('Search results', [
                new FilterGroup('title', [
                    new Filter(true, 'something', 10),
                    new Filter(true, 'something', 100),
                    new Filter(true, 'something', 1000),
                ]),
            ], Button::form('search', 'submit', Button::SIZE_SMALL))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/filter-panel.mustache';
    }
}
