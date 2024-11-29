<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Footer;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\InvestorLogos;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MainMenu;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\SiteHeaderTitle;

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
            'title' => [
                'homePagePath' => '/home/page/path',
                'isWrapped' => false,
                'borderVariant' => false,
            ],
            'listHeading' => [
                'heading' => 'Menu',
            ],
            'links' => ['items' => [['name' => 'name1', 'url' => 'url1']]],
            'footerMenuLinks' => [['name' => 'name2', 'url' => 'url2']],
            'logos' => [
                [
                    'fallback' => [
                        'altText' => 'alt',
                        'defaultPath' => 'foo.jpg',
                    ],
                ],
            ],
        ];

        $footer = new Footer(
            new MainMenu(
                new SiteHeaderTitle('/home/page/path'),
                $links = [
                    new Link($data['links']['items'][0]['name'], $data['links']['items'][0]['url']),
                ]
            ),
            $footerMenuLinks = [new Link($data['footerMenuLinks'][0]['name'], $data['footerMenuLinks'][0]['url'])],
            new InvestorLogos(...array_map(function (array $logo) {
                return new Picture([], new Image($logo['fallback']['defaultPath'], [], $logo['fallback']['altText']));
            }, $data['logos']))
        );

        $this->assertSame($data['year'], $footer['year']);
        $this->assertEquals($data['mainMenu'], $footer['mainMenu']);
        $this->assertSame($data['title'], $footer['title']->toArray());
        $this->assertEquals($links, $footer['links']['items']);
        $this->assertSame($data['listHeading'], $footer['listHeading']->toArray());
        $this->assertEquals($footerMenuLinks, $footer['footerMenuLinks']);
        $this->assertSameWithoutOrder($data['logos'], $footer['logos']);
        $this->assertSame($data, $footer->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            [
                new Footer(
                    new MainMenu(new SiteHeaderTitle('/home/page/path'), [new Link('name1', 'url1')]),
                    [new Link('name2', 'url2')],
                    new InvestorLogos(new Picture([], new Image('foo.jpg')))
                ),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/footer.mustache';
    }
}
