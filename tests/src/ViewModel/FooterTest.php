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
                    'titleId' => 'titleId',
                    'links' => [['name' => 'name1', 'url' => 'url1']],
                ],
            ],
            'footerMenuLinks1' => [['name' => 'name2', 'url' => 'url2']],
            'footerMenuLinks2' => [['name' => 'name3', 'url' => 'url3']],
        ];

        $footer = new Footer(
            $data['assetsPath'],
            new MainMenu($mainMenuLinks = [
                new MainMenuLink($data['mainMenuLinks'][0]['title'], $data['mainMenuLinks'][0]['titleId'],
                    $links = [
                        new Link($data['mainMenuLinks'][0]['links'][0]['name'],
                            $data['mainMenuLinks'][0]['links'][0]['url']),
                    ]),
            ]),
            $footerMenuLinks1 = [new Link($data['footerMenuLinks1'][0]['name'], $data['footerMenuLinks1'][0]['url'])],
            $footerMenuLinks2 = [new Link($data['footerMenuLinks2'][0]['name'], $data['footerMenuLinks2'][0]['url'])]
        );

        $this->assertSame($data['year'], $footer['year']);
        $this->assertSame($data['assetsPath'], $footer['assetsPath']);
        $this->assertEquals($mainMenuLinks, $footer['mainMenuLinks']);
        $this->assertEquals($footerMenuLinks1, $footer['footerMenuLinks1']);
        $this->assertEquals($footerMenuLinks2, $footer['footerMenuLinks2']);
        $this->assertSame($data, $footer->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new Footer('/', new MainMenu([new MainMenuLink('title', 'titleId', [new Link('name1', 'url1')])]),
                    [new Link('name2', 'url2')], [new Link('name3', 'url3')]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/footer.mustache';
    }
}
