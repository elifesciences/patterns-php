<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MainMenu;

final class MainMenuTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'links' => ['items' => [['name' => 'name', 'url' => 'url']]],
            'button' => [
                'classes' => 'button--small button--default button--full main_menu__quit',
                'path' => '#siteHeader',
                'text' => 'Back to top',
            ],
        ];

        $mainMenu = new MainMenu($links = [
            new Link($data['links']['items'][0]['name'], $data['links']['items'][0]['url']),
        ]);

        $this->assertEquals($links, $mainMenu['links']['items']);
        $this->assertSame($data, $mainMenu->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new MainMenu([new Link('name', 'url')])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/main-menu.mustache';
    }
}
