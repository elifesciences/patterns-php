<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Highlight;
use eLife\Patterns\ViewModel\HighlightItem;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListHeading;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Picture;
use InvalidArgumentException;

final class HighlightTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'heading' => [
                'heading' => 'heading',
                'headingId' => 'headingId',
            ],
            'items' => [
                [
                    'subjects' => [
                        'list' => [
                            [
                                'name' => 'subject',
                                'url' => 'subject-url',
                            ],
                        ],
                    ],
                    'link' => [
                        'name' => 'highlight item',
                        'url' => 'highlight-item-url'
                    ],
                    'summary' => "summary",
                    'authors' => "authors",
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
                ],
            ],
        ];
        $highlightItem = new HighlightItem(
            [new Link('subject', 'subject-url')],
            new Link('highlight item', 'highlight-item-url'),
            Meta::withText('meta'),
            new Picture([], new Image('/default/path')),
            'summary',
            'authors'
        );
        $highlight = new Highlight([$highlightItem], new ListHeading('heading', 'headingId'));

        $this->assertSame($data, $highlight->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_item()
    {
        $this->expectException(InvalidArgumentException::class);

        new Highlight([], new ListHeading('heading'));
    }

    public function viewModelProvider(): array
    {
        return [
            [
                new Highlight([
                    new HighlightItem(
                        [new Link('subject', 'subject-url')],
                        new Link('highlight item', 'highlight-item-url'),
                        Meta::withText('meta'),
                        new Picture([], new Image('/default/path'))
                    ),
                    new HighlightItem(
                        [new Link('subject', 'subject-url')],
                        new Link('highlight item', 'highlight-item-url'),
                        Meta::withText('meta', Date::simple(new DateTimeImmutable())),
                        new Picture([], new Image('/default/path')),
                        'summary',
                        'authors'
                    )
                ], new ListHeading('heading', 'headingId')),
            ]
        ];
    }

    /**
     * @test
     */
    public function it_cannot_have_no_highlight_items()
    {
        $this->expectException(InvalidArgumentException::class);

        new Highlight([], new ListHeading('heading', 'headingId'));
    }

    /**
     * @test
     */
    public function it_must_have_only_highlight_items()
    {
        $this->expectException(InvalidArgumentException::class);

        new Highlight(['foo'], new ListHeading('heading', 'headingId'));
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/highlight.mustache';
    }
}
