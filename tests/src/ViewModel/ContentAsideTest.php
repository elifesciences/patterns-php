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
            'title' => "Research article"
        ];

        $contentAside = new ContentAside($data['title']);

        $this->assertSame($data['title'], $contentAside['status']['title']);

        $data = [
            'title' => 'Research article',
            'description' => 'The author(s) have declared this to be the current/final version.',
            'link' => [
                'name' => 'About eLife\'s process',
                'url' => '#',
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
                'variant' => 'timeline'
            ]
        ];

        $contentAside = new ContentAside(
            $data['title'],
            $data['description'],
            new Link($data['link']['name'], $data['link']['url']),
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

        $this->assertSame($data['title'], $contentAside['status']['title']);
        $this->assertSame($data['description'], $contentAside['status']['description']);
        $this->assertSame($data['link']['name'], $contentAside['status']['link']);
        $this->assertSame($data['link']['url'], $contentAside['status']['url']);
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

        new ContentAside('');
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ContentAside('Research article')],
            'complete' => [
                new ContentAside(
                    'Research article',
                    'The author(s) have declared this to be the current/final version.',
                    new Link('About eLife\'s process', '#'),
                    new ButtonCollection([Button::action('text', '#')], true),
                    ContextualData::withMetrics(['foo']),
                    DefinitionList::timeline(['foo' => ['bar']]))
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/content-aside.mustache';
    }
}
