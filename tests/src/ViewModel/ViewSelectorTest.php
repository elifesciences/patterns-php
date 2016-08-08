<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ViewSelector;

final class ViewSelectorTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'articleUrl' => '#',
            'jumpLinks' => [
                [
                    'name' => 'some link',
                    'url' => '#',
                ],

                [
                    'name' => 'some link',
                    'url' => '#',
                ],

                [
                    'name' => 'some link',
                    'url' => '#',
                ],
            ],
            'figureUrl' => '#',
        ];

        $viewSelector = new ViewSelector($data['articleUrl'], array_map(function ($link) {
            return new Link($link['name'], $link['url']);
        }, $data['jumpLinks']), $data['figureUrl']);

        $this->assertSameWithoutOrder($data, $viewSelector);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new ViewSelector('#', [
                    new Link('some link', '#'),
                ], '#'),
            ],
            [
                new ViewSelector('#', [
                    new Link('some link', '#'),
                ]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/view-selector.mustache';
    }
}
