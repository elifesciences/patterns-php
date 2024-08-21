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
use eLife\Patterns\ViewModel\PreviousVersionWarning;
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
            'status' => [
                'title' => 'Research article',
                'titleLength' => 'short',
                'description' => 'The author(s) have declared this to be the current/final version.',
                'link' => [
                    'name' => 'About eLife\'s process',
                    'url' => '#',
                ],
            ],
            'actionButtons' => [
                'buttons' => [
                    [
                        'classes' => 'button--default button--action',
                        'path' => '#',
                        'text' => 'text',
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
                'variant' => 'timeline',
                'color' => 'vor'
            ],
            'related' => [
                'items' => [
                   [
                       'title' => 'title',
                       'rootClasses' => 'teaser--secondary',
                       'url' => 'url',
                   ],
                   [
                       'title' => 'title',
                       'rootClasses' => 'teaser--secondary',
                       'url' => 'url',
                   ],
                   [
                       'title' => 'title',
                       'rootClasses' => 'teaser--secondary',
                       'url' => 'url',
                   ],
                ],
                'highlights' => false,
            ],
            'previousVersion' => [
                'text' => 'text',
                'link' => [
                    'name' => 'Previous version',
                    'url' => '#',
                ],
            ]
        ];

        $contentAside = new ContentAside(
            new ContentAsideStatus(
                $data['status']['title'],
                $data['status']['description'],
                new Link($data['status']['link']['name'], $data['status']['link']['url'])
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
            DefinitionList::timeline($data['timeline']['items'], $data['timeline']['color']),
            ListingTeasers::basic(
                array_map(function ($item) {
                    return Teaser::basic($item['title'], $item['url']);
                }, $data['related']['items'])
            ),
            new PreviousVersionWarning(
                $data['previousVersion']['text'],
                new Link($data['previousVersion']['link']['name'], $data['previousVersion']['link']['url'])
            ),
        );

        $this->assertSame($data['status'], $contentAside['status']->toArray());
        $this->assertSame($data['actionButtons'], $contentAside['actionButtons']->toArray());
        $this->assertSame($data['metrics'], $contentAside['metrics']->toArray());
        $this->assertSame($data['timeline'], $contentAside['timeline']->toArray());
        $this->assertSame($data['related'], $contentAside['related']->toArray());
        $this->assertSame($data['previousVersion'], $contentAside['previousVersion']->toArray());
        $this->assertSame($data, $contentAside->toArray());
    }

    /**
     * @test
     */
    public function it_may_have_a_status()
    {
        $with = new ContentAside(new ContentAsideStatus("content aside"));
        $without = new ContentAside();

        $this->assertArrayHasKey('status', $with->toArray());
        $this->assertSame('content aside', $with['status']['title']);

        $this->assertArrayNotHasKey('status', $without);
    }

    /**
     * @test
     */
    public function it_may_have_a_previous_version()
    {
        $with = new ContentAside(null, null, null, null, null, new PreviousVersionWarning("text"));
        $without = new ContentAside(null, null, null, null, null, null);

        $this->assertArrayHasKey('previousVersion', $with->toArray());
        $this->assertSame('text', $with['previousVersion']['text']);

        $this->assertArrayNotHasKey('previousVersion', $without);
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
                    ]),
                    new PreviousVersionWarning(
                        'Text',
                        new Link('Previous version', '#')
                    )
                )
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/content-aside.mustache';
    }
}
