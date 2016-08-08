<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\SiteLinks;
use eLife\Patterns\ViewModel\SiteLinksList;

final class SiteLinksListTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'lists' => [
                [
                    'listItems' => [
                        [
                            'name' => 'item 1',
                            'url' => '#',
                        ],
                        [
                            'name' => 'item 2',
                            'url' => '#',
                        ],
                        [
                            'name' => 'item 3',
                            'url' => '#',
                        ],
                        [
                            'name' => 'item 4',
                            'url' => '#',
                        ],
                    ],
                ],
                [
                    'listItems' => [
                        [
                            'name' => 'item 5',
                            'url' => '#',
                        ],
                        [
                            'name' => 'item 6',
                            'url' => '#',
                        ],
                        [
                            'name' => 'item 7',
                            'url' => '#',
                        ],
                        [
                            'name' => 'item 8',
                            'url' => '#',
                        ],
                    ],
                ],
            ],

        ];
        $siteLinksList = new SiteLinksList([
            new SiteLinks([
                new Link($data['lists'][0]['listItems'][0]['name'], $data['lists'][0]['listItems'][0]['url']),
                new Link($data['lists'][0]['listItems'][1]['name'], $data['lists'][0]['listItems'][1]['url']),
                new Link($data['lists'][0]['listItems'][2]['name'], $data['lists'][0]['listItems'][2]['url']),
                new Link($data['lists'][0]['listItems'][3]['name'], $data['lists'][0]['listItems'][3]['url']),
            ]),
            new SiteLinks([
                new Link($data['lists'][1]['listItems'][0]['name'], $data['lists'][1]['listItems'][0]['url']),
                new Link($data['lists'][1]['listItems'][1]['name'], $data['lists'][1]['listItems'][1]['url']),
                new Link($data['lists'][1]['listItems'][2]['name'], $data['lists'][1]['listItems'][2]['url']),
                new Link($data['lists'][1]['listItems'][3]['name'], $data['lists'][1]['listItems'][3]['url']),
            ]),
        ]);

        $this->assertSame($data, $siteLinksList->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new SiteLinksList([
                new SiteLinks([
                    new Link('item 1', '#'),
                    new Link('item 2', '#'),
                    new Link('item 3', '#'),
                    new Link('item 4', '#'),
                ]),
                new SiteLinks([
                    new Link('item 5', '#'),
                    new Link('item 6', '#'),
                    new Link('item 7', '#'),
                    new Link('item 8', '#'),
                ]),
            ])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/site-links-list.mustache';
    }
}
