<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ButtonCollection;
use eLife\Patterns\ViewModel\ContentAside;
use eLife\Patterns\ViewModel\ContextualData;
use eLife\Patterns\ViewModel\DefinitionList;
use eLife\Patterns\ViewModel\Link;
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
                'title' => "Research article",
            ]
        ];

        $contentAside = new ContentAside($data['status']);

        $this->assertSame($data['status'], $contentAside['status']);
        $this->assertSame($data, $contentAside->toArray());

        $data = [
            'status' => [
                'title' => 'Research article',
                'description' => 'The author(s) have declared this to be the current/final version.',
                'link' => 'About eLife\'s process',
                'url' => '#'
            ],
            new ButtonCollection([Button::action('text', '#')], true),
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
            'contextualData' => [
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
                'isCollapsible' => true,
            ]
        ];

        $contentAside = new ContentAside(
            $data['status'],
            new Link($data['status']['link'], $data['status']['url']),
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
            DefinitionList::timeline(array_reduce($data['timeline']['items'], function (array $carry, array $item) {
                $carry[$item['term']] = $item['descriptors'];

                return $carry;
            }, []))
        );

        $this->assertSameWithoutOrder($data['actionButtons'], $contentAside['actionButtons']);
        $this->assertSameWithoutOrder($data['contextualData'], $contentAside['contextualData']);
        $this->assertSameWithoutOrder($data['timeline'], $contentAside['timeline']);
    }

    /**
     * @test
     */
    public function it_must_have_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentAside(['title' => '']);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ContentAside(['title' => 'Research article'])],
            'complete' => [
                new ContentAside(['title' => 'Research article'],
                    new Link('About eLife\'s process', '#'),
                    new ButtonCollection([Button::action('text', '#')], true),
                    ContextualData::withMetrics(['foo']),
                    DefinitionList::timeline(['foo' => ['bar']]))
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/content-header-simple.mustache';
    }
}
