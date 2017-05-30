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
                        'option' => 'option 1',
                        'url' => '#',
                        'sorting' => 'ascending',
                    ],

                    [
                        'option' => 'option 2',
                        'url' => '#',
                    ],
                ],
        ];
        $sortControl = new SortControl([
            new SortControlOption(new Link($data['options'][0]['option'], $data['options'][0]['url']), $data['options'][0]['sorting']),
            new SortControlOption(new Link($data['options'][1]['option'], $data['options'][1]['url'])),
        ]);

        $this->assertSame($data, $sortControl->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new SortControl([
                    new SortControlOption(new Link('option 1', '#'), SortControlOption::ASC),
                    new SortControlOption(new Link('option 2', '#'), SortControlOption::DESC),
                ]),
            ],
            [
                new SortControl([
                    new SortControlOption(new Link('alt option 1', '#'), 'descending'),
                    new SortControlOption(new Link('alt option 2', '#')),
                ]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/sort-control.mustache';
    }
}
