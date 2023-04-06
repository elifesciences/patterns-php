<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\TabbedNavigation;
use eLife\Patterns\ViewModel\TabbedNavigationLink;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

final class TabbedNavigationTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'items' => [
                [
                    'name' => 'Tabbed navigation1',
                    'url' => 'http://google.com',
                    'selectedClass' => ' tabbed-navigation__tab-label--active'
                ],
                [
                    'name' => 'Tabbed navigation2',
                    'url' => 'http://google.com'
                ]
            ]
        ];

        $tabbedNavigation = new TabbedNavigation(
            [
                TabbedNavigationLink::fromLink(
                    new Link($data['items'][0]['name'], $data['items'][0]['url']),
                    $data['items'][0]['selectedClass']
                ),
                TabbedNavigationLink::fromLink(
                    new Link($data['items'][1]['name'], $data['items'][1]['url'])
                )
            ]
        );

        $this->assertSame($data['items'][0], $tabbedNavigation['items'][0]->toArray());
        $this->assertSame($data['items'][1], $tabbedNavigation['items'][1]->toArray());

        $this->assertSame($data, $tabbedNavigation->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_item()
    {
        $this->expectException(InvalidArgumentException::class);

        new TabbedNavigation([]);
    }

    public function viewModelProvider() : array
    {
        return [
            'default' => [
                new TabbedNavigation(
                    [
                        TabbedNavigationLink::fromLink(new Link('Tabbed navigation1', 'http://google.com'), ' tabbed-navigation__tab-label--active'),
                        TabbedNavigationLink::fromLink(new Link('Tabbed navigation2', 'http://google.com')),
                        TabbedNavigationLink::fromLink(new Link('Tabbed navigation2', 'http://google.com'))
                    ]
                )
            ],
            'one link with selected class' => [
                new TabbedNavigation(
                    [
                        TabbedNavigationLink::fromLink(new Link('Tabbed navigation1', 'http://google.com'), ' tabbed-navigation__tab-label--active')
                    ]
                )
            ],
            'two links with and without selected class' => [
                new TabbedNavigation(
                    [
                        TabbedNavigationLink::fromLink(new Link('Tabbed navigation1', 'http://google.com'), ' tabbed-navigation__tab-label--active'),
                        TabbedNavigationLink::fromLink(new Link('Tabbed navigation2', 'http://google.com'))
                    ]
                )
            ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/tabbed-navigation.mustache';
    }
}
