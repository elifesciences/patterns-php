<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ViewSelector;
use InvalidArgumentException;

final class ViewSelectorTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'articleUrl' => 'article',
            'jumpLinks' => [
                'links' => [
                    [
                        'name' => 'link 1',
                        'url' => 'link1',
                    ],

                    [
                        'name' => 'link 2',
                        'url' => 'link2',
                    ],
                ],
            ],
            'figureUrl' => 'figures',
            'figureIsActive' => true,
            'sideBySideUrl' => 'side-by-side',
        ];

        $viewSelector = new ViewSelector($data['articleUrl'], $links = array_map(function ($link) {
            return new Link($link['name'], $link['url']);
        }, $data['jumpLinks']['links']), $data['figureUrl'], $data['figureIsActive'], $data['sideBySideUrl']);

        $this->assertSame($data['articleUrl'], $viewSelector['articleUrl']);
        $this->assertEquals($links, $viewSelector['jumpLinks']['links']);
        $this->assertSame($data['figureUrl'], $viewSelector['figureUrl']);
        $this->assertSame($data['figureIsActive'], $viewSelector['figureIsActive']);
        $this->assertSame($data['sideBySideUrl'], $viewSelector['sideBySideUrl']);
        $this->assertSameWithoutOrder($data, $viewSelector);
    }

    /**
     * @test
     */
    public function it_must_have_at_least_2_jump_links_if_any()
    {
        $this->expectException(InvalidArgumentException::class);

        new ViewSelector('article', [new Link('some link', '#')]);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [
                new ViewSelector('article'),
            ],
            'complete' => [
                new ViewSelector('article', [new Link('some link', '#'), new Link('some link', '#')], 'figures', true, 'side-by-side'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/view-selector.mustache';
    }
}
