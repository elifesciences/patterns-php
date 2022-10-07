<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MainMenu;
use eLife\Patterns\ViewModel\SiteHeaderTitle;

final class MainMenuTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => [
                'homePagePath' => '/home/page/path',
                'isWrapped' => false,
                'borderVariant' => false,
            ],
            'links' => [
                'items' => [
                    ['name' => 'name', 'url' => 'url'],
                    ['name' => 'name2', 'url' => 'url2', 'classes' => 'end-of-group'],
                    ['name' => 'name3', 'url' => 'url3', 'classes' => 'hidden-wide end-of-group'],
                ]
            ],
            'listHeading' => [
                'heading' => 'Menu',
            ],
        ];

        $mainMenu = new MainMenu(
            $title = new SiteHeaderTitle('/home/page/path'),
            $links = [
                new Link($data['links']['items'][0]['name'], $data['links']['items'][0]['url']),
                (new Link($data['links']['items'][1]['name'], $data['links']['items'][1]['url']))->endOfGroup(),
                (new Link($data['links']['items'][2]['name'], $data['links']['items'][2]['url']))->hiddenWide()->endOfGroup(),
            ]
        );

        $this->assertEquals($title, $mainMenu['title']);
        $this->assertEquals($links, $mainMenu['links']['items']);
        $this->assertSame($data['listHeading'], $mainMenu['listHeading']->toArray());
        $this->assertSame($data, $mainMenu->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new MainMenu(new SiteHeaderTitle('/home/page/path'), [new Link('name', 'url')])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/main-menu.mustache';
    }
}
