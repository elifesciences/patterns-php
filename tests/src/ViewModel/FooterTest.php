<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Footer;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MainMenu;
use eLife\Patterns\ViewModel\MainMenuLink;

final class FooterTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'year' => (int) date('Y'),
            'assetsPath' => '/assets',
            'mainMenuLinks' => [
                [
                    'title' => 'title',
                    'titleId' => 'mainMenu'.hash('crc32', 'title'),
                    'items' => [['name' => 'name1', 'url' => 'url1']],
                ],
            ],
            'footerMenuLinks' => [['name' => 'name2', 'url' => 'url2']],
        ];

        $footer = new Footer(
            $data['assetsPath'],
            new MainMenu($mainMenuLinks = [
                new MainMenuLink($data['mainMenuLinks'][0]['title'],
                    $links = [
                        new Link($data['mainMenuLinks'][0]['items'][0]['name'],
                            $data['mainMenuLinks'][0]['items'][0]['url']),
                    ]),
            ]),
            $footerMenuLinks = [new Link($data['footerMenuLinks'][0]['name'], $data['footerMenuLinks'][0]['url'])]
        );

        $this->assertSame($data['year'], $footer['year']);
        $this->assertSame($data['assetsPath'], $footer['assetsPath']);
        $this->assertEquals($mainMenuLinks, $footer['mainMenuLinks']);
        $this->assertEquals($footerMenuLinks, $footer['footerMenuLinks']);
        $this->assertSame($data, $footer->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new Footer('/', new MainMenu([new MainMenuLink('title', [new Link('name1', 'url1')])]),
                    [new Link('name2', 'url2')], [new Link('name3', 'url3')]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/footer.mustache';
    }
}
