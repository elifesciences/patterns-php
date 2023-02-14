<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ButtonCollection;
use eLife\Patterns\ViewModel\ContentAside;
use eLife\Patterns\ViewModel\ContentAsideStatus;
use eLife\Patterns\ViewModel\ContextualData;
use eLife\Patterns\ViewModel\DefinitionList;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListingTeasers;
use eLife\Patterns\ViewModel\Teaser;
use InvalidArgumentException;

final class ContentAsideTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'Research article',
            'description' => 'The author(s) have declared this to be the current/final version.',
            'link' => [
                'name' => 'About eLife\'s process',
                'url' => '#',
            ],
            'actionButtons' => [
                'buttons' => [
                    [
                        'text' => 'text',
                        'classes' => 'button--default',
                        'path' => '#'
                    ],
                ],
                'inline' => true,
            ],
            'metrics' => [
                'metricsData' => [
                    'data' => [
                        [
                            'text' => 'foo',
                        ],
                    ],
                ],
            ],
            'timeline' => [
                'items' => [
                    [
                        'term' => 'foo',
                        'descriptors' => ['bar'],
                    ]
                ],
                'variant' => 'timeline'
            ],
            'related' => ListingTeasers::basic([
                Teaser::basic('title', 'url'),
                Teaser::basic('title', 'url'),
                Teaser::basic('title', 'url'),
            ])
        ];

        $contentAside = new ContentAside(
            new ContentAsideStatus(
                $data['title'],
                $data['description'],
                new Link($data['link']['name'], $data['link']['url'])
            ),
            new ButtonCollection(
                [
                    Button::action(
                        $data['actionButtons']['buttons'][0]['text'],
                        $data['actionButtons']['buttons'][0]['path']
                    )
                ],
                $data['actionButtons']['inline']
            ),
            ContextualData::withMetrics(['foo']),
            DefinitionList::timeline($data['timeline']['items']),
            ListingTeasers::basic(
                array_map(function ($item) {
                    return Teaser::basic($item['title'], $item['url']);
                }, $data['related']['items'])
            )
        );

        $this->assertSame($data['title'], $contentAside['status']['title']);
        $this->assertSame($data['description'], $contentAside['status']['description']);
        $this->assertSame($data['link']['name'], $contentAside['status']['link']['name']);
        $this->assertSame($data['link']['url'], $contentAside['status']['link']['url']);
        $this->assertSameWithoutOrder($data['actionButtons'], $contentAside['actionButtons']);
        $this->assertSameWithoutOrder($data['metrics'], $contentAside['metrics']);
        $this->assertSameWithoutOrder($data['timeline'], $contentAside['timeline']);
        $this->assertSameWithoutOrder($data['related'], $contentAside['related']);
    }

    /**
     * @test
     */
    public function it_may_have_a_status()
    {
        $with = new ContentAside(new ContentAsideStatus("content aside"));
        $without = new ContentAside();

        $this->assertSame('content aside', $with['status']['title']);
        $this->assertNull($without['status']);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ContentAside()],
            'complete' => [
                new ContentAside(
                    new ContentAsideStatus(
                        'Research article',
                        'The author(s) have declared this to be the current/final version.',
                        new Link('About eLife\'s process', '#')
                    ),
                    new ButtonCollection([Button::action('text', '#')], true),
                    ContextualData::withMetrics(['foo']),
                    DefinitionList::timeline([['term' => 'foo', 'descriptors' => ['bar']]]),
                    ListingTeasers::basic([
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                    ])
                )
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/content-aside.mustache';
    }
}
