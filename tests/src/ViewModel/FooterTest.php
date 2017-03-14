<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Footer;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MainMenu;

final class FooterTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'year' => (int) date('Y'),
            'mainMenu' => true,
            'links' => ['items' => [['name' => 'name1', 'url' => 'url1']]],
            'button' => [
                'classes' => 'button--small button--default button--full main_menu__quit',
                'path' => '#siteHeader',
                'text' => 'Back to top',
            ],
            'footerMenuLinks' => [['name' => 'name2', 'url' => 'url2']],
        ];

        $footer = new Footer(
            new MainMenu($links = [
                new Link($data['links']['items'][0]['name'], $data['links']['items'][0]['url']),
            ]),
            $footerMenuLinks = [new Link($data['footerMenuLinks'][0]['name'], $data['footerMenuLinks'][0]['url'])]
        );

        $this->assertSame($data['year'], $footer['year']);
        $this->assertSame($data['mainMenu'], $footer['mainMenu']);
        $this->assertEquals($links, $footer['links']['items']);
        $this->assertSame($data['button'], $footer['button']->toArray());
        $this->assertEquals($footerMenuLinks, $footer['footerMenuLinks']);
        $this->assertSame($data, $footer->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new Footer(new MainMenu([new Link('name1', 'url1')]),
                    [new Link('name2', 'url2')], [new Link('name3', 'url3')]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/footer.mustache';
    }
}
