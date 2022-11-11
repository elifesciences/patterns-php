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
            'primaryUrl' => '#article',
            'primaryLabel' => 'article',
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
            'secondaryUrl' => '#figures',
            'secondaryLabel' => 'figures',
            'secondaryIsActive' => true,
            'sideBySideUrl' => 'side-by-side',
            'otherLinks' => [
                [
                    'name' => 'link 3',
                    'url' => 'link3',
                ],
            ],
        ];

        $viewSelector = new ViewSelector(
            new Link($data['primaryLabel'], $data['primaryUrl']),
            $jumpLinks = array_map(function ($link) {
                return new Link($link['name'], $link['url']);
            }, $data['jumpLinks']['links']),
            new Link($data['secondaryLabel'], $data['secondaryUrl']),
            $data['secondaryIsActive'],
            $data['sideBySideUrl'],
            $otherLinks = array_map(function ($link) {
                return new Link($link['name'], $link['url']);
            }, $data['otherLinks'])
        );

        $this->assertSame($data['primaryUrl'], $viewSelector['primaryUrl']);
        $this->assertSame($data['primaryLabel'], $viewSelector['primaryLabel']);
        $this->assertEquals($jumpLinks, $viewSelector['jumpLinks']['links']);
        $this->assertSame($data['secondaryUrl'], $viewSelector['secondaryUrl']);
        $this->assertSame($data['secondaryLabel'], $viewSelector['secondaryLabel']);
        $this->assertSame($data['secondaryIsActive'], $viewSelector['secondaryIsActive']);
        $this->assertSame($data['sideBySideUrl'], $viewSelector['sideBySideUrl']);
        $this->assertEquals($otherLinks, $viewSelector['otherLinks']);
        $this->assertSameWithoutOrder($data, $viewSelector);
    }

    /**
     * @test
     */
    public function it_must_have_at_least_2_jump_links_if_any()
    {
        $this->expectException(InvalidArgumentException::class);

        new ViewSelector(new Link('article', '#article'), [new Link('some link', '#')]);
    }

    /**
     * @test
     */
    public function it_must_have_a_primary_url()
    {
        $this->expectException(InvalidArgumentException::class);

        new ViewSelector(new Link('article'));
    }

    /**
     * @test
     */
    public function it_must_have_a_secondary_url_if_secondary_link_provided()
    {
        $this->expectException(InvalidArgumentException::class);

        new ViewSelector(new Link('article', '#article'), [], new Link('figures'));
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [
                new ViewSelector(new Link('article', '#article')),
            ],
            'complete' => [
                new ViewSelector(
                    new Link('article', '#article'),
                    [new Link('some link', '#'), new Link('some link', '#')],
                    new Link('figures', '#figures'),
                    true,
                    'side-by-side',
                    [new Link('some link', '#')]
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/view-selector.mustache';
    }
}
