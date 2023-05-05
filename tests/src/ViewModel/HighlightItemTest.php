<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
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
            'link' => [
                'name' => 'highlight item with a long title',
                'url' => 'carousel-item-url'
            ],
            'summary' => "summary",
            'authors' => "authors",
            'meta' => [
                'url' => false,
                'text' => 'meta',
                'date' => [
                    'isExpanded' => false,
                    'isUpdated' => false,
                    'forHuman' => [
                        'dayOfMonth' => 21,
                        'month' => 'Dec',
                        'year' => 2017,
                    ],
                    'forMachine' => '2017-12-21',
                ],
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
            Meta::withText('meta', Date::simple(new DateTimeImmutable('2017-12-21'))),
            new Picture([], new Image('/default/path')),
            'summary',
            'authors'
        );

        $this->assertSame($data['subjects']['list'][0], $highlightItem['subjects']['list'][0]->toArray());
        $this->assertSame($data['link'], $highlightItem['link']->toArray());
        $this->assertSame($data['summary'], $highlightItem['summary']);
        $this->assertSame($data['authors'], $highlightItem['authors']);
        $this->assertSame($data['meta'], $highlightItem['meta']->toArray());
        $this->assertSame($data['image'], $highlightItem['image']->toArray());
        $this->assertSame($data, $highlightItem->toArray());
    }

    /**
     * @test
     */
    public function it_may_have_a_summary()
    {
        $with = new HighlightItem(
            [],
            new Link('highlight item with a long title', 'highlight-item-url'),
            Meta::withText('meta'),
            new Picture([], new Image('/default/path')),
            'summary'
        );

        $without = new HighlightItem(
            [],
            new Link('highlight item with a long title', 'highlight-item-url'),
            Meta::withText('meta'),
            new Picture([], new Image('/default/path'))
        );

        $this->assertArrayHasKey('summary', $with->toArray());

        $this->assertArrayNotHasKey('summary', $without->toArray());
    }

    /**
     * @test
     */
    public function it_may_have_authors()
    {
        $with = new HighlightItem(
            [],
            new Link('highlight item with a long title', 'highlight-item-url'),
            Meta::withText('meta'),
            new Picture([], new Image('/default/path')),
            null,
            'Author line'
        );

        $without = new HighlightItem(
            [],
            new Link('highlight item with a long title', 'highlight-item-url'),
            Meta::withText('meta'),
            new Picture([], new Image('/default/path'))
        );

        $this->assertArrayHasKey('authors', $with->toArray());

        $this->assertArrayNotHasKey('authors', $without->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new HighlightItem(
                [],
                new Link('highlight item', 'highlight-item-url'),
                Meta::withText('meta'),
                new Picture([], new Image('/default/path'))
            )],
            'complete' => [new HighlightItem(
                [new Link('subject', 'subject-url')],
                new Link('highlight item', 'highlight-item-url'),
                Meta::withText('meta', Date::simple(new DateTimeImmutable())),
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
