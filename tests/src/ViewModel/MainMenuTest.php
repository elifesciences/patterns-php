<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MainMenu;
use eLife\Patterns\ViewModel\MainMenuLink;

final class MainMenuTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'mainMenuLinks' => [
                [
                    'title' => 'title',
                    'titleId' => 'titleId',
                    'items' => [['name' => 'name', 'url' => 'url']],
                ],
            ],
        ];

        $mainMenu = new MainMenu($mainMenuLinks = [
            new MainMenuLink($data['mainMenuLinks'][0]['title'], $data['mainMenuLinks'][0]['titleId'],
                [
                    new Link($data['mainMenuLinks'][0]['items'][0]['name'],
                        $data['mainMenuLinks'][0]['items'][0]['url']),
                ]),
        ]);

        $this->assertEquals($mainMenuLinks, $mainMenu['mainMenuLinks']);
        $this->assertSame($data, $mainMenu->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new MainMenu([new MainMenuLink('title', 'titleId', [new Link('name', 'url')])])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/main-menu.mustache';
    }
}
