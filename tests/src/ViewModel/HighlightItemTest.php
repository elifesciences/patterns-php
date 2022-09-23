<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\HighlightItem;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Picture;

final class HighlightItemTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'subjects' => [
                'list' => [
                    [
                        'name' => 'subject',
                        'url' => 'subject-url',
                    ],
                ],
            ],
            'title' => 'highlight item with a long title',
            'titleLength' => 'x-short',
            'summary' => "summary",
            'authors' => "authors",
            'url' => 'carousel-item-url',
            'meta' => [
                'url' => false,
                'text' => 'meta',
            ],
            'image' => [
                'fallback' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                ],
            ],
        ];

        $highlightItem = new HighlightItem(
            [new Link('subject', 'subject-url')],
            new Link('highlight item with a long title', 'carousel-item-url'),
            Meta::withText('meta'),
            new Picture([], new Image('/default/path')),
            'summary',
            'authors'
        );

        $this->assertSame($data['subjects']['list'][0], $highlightItem['subjects']['list'][0]->toArray());
        $this->assertSame($data['title'], $highlightItem['title']);
        $this->assertSame($data['titleLength'], $highlightItem['titleLength']);
        $this->assertSame($data['url'], $highlightItem['url']);
        $this->assertSame($data['summary'], $highlightItem['summary']);
        $this->assertSame($data['authors'], $highlightItem['authors']);
        $this->assertSame($data['meta'], $highlightItem['meta']->toArray());
        $this->assertSame($data['image'], $highlightItem['image']->toArray());
        $this->assertSame($data, $highlightItem->toArray());
    }

    /**
     * @test
     * @dataProvider titleLengthProvider
     */
    public function a_title_has_the_correct_designation_for_its_length(int $length, string $expected)
    {
        $title = str_repeat('é', $length);

        $carouselItem = new HighlightItem(
            [],
            new Link($title, 'carousel-item-url'),
            Meta::withText('meta'),
            new Picture([], new Image('/default/path')),
            'summary',
            'authors'
        );

        $this->assertSame($expected, $carouselItem['titleLength']);
    }

    public function titleLengthProvider() : array
    {
        return [
            [3, 'xx-short'],
            [19, 'xx-short'],
            [20, 'x-short'],
            [35, 'x-short'],
            [36, 'short'],
            [46, 'short'],
            [47, 'medium'],
            [57, 'medium'],
            [58, 'long'],
            [80, 'long'],
            [81, 'x-long'],
            [120, 'x-long'],
            [121, 'xx-long'],
            [500, 'xx-long'],
        ];
    }

    public function viewModelProvider() : array
    {
        return [
            [new HighlightItem(
                [new Link('subject', 'subject-url')],
                new Link('carousel item', 'carousel-item-url'),
                Meta::withText('meta'),
                new Picture([], new Image('/default/path')),
                'summary',
                'authors'
            )],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/highlight-item.mustache';
    }
}
