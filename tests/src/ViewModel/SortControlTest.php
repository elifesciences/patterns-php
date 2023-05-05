<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\SortControl;
use eLife\Patterns\ViewModel\SortControlOption;

final class SortControlTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'options' => [
                    [
                        'link' => [
                            'name' => 'name 1',
                            'url' => '#'
                        ],
                        'sorting' => 'ascending',
                    ],

                    [
                        'link' => [
                            'name' => 'name 2',
                            'url' => '#'
                        ],
                    ],
                ],
        ];
        $sortControl = new SortControl([
            new SortControlOption(new Link($data['options'][0]['link']['name'], $data['options'][0]['link']['url']), $data['options'][0]['sorting']),
            new SortControlOption(new Link($data['options'][1]['link']['name'], $data['options'][1]['link']['url'])),
        ]);

        $this->assertSame($data, $sortControl->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new SortControl([
                    new SortControlOption(new Link('name 1', '#'), SortControlOption::ASC),
                    new SortControlOption(new Link('name 2', '#'), SortControlOption::DESC),
                ]),
            ],
            [
                new SortControl([
                    new SortControlOption(new Link('alt name 1', '#'), 'descending'),
                    new SortControlOption(new Link('alt name 2', '#')),
                ]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/sort-control.mustache';
    }
}
