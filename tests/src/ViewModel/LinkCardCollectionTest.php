<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\LinkCard;
use eLife\Patterns\ViewModel\LinkCardCollection;
use InvalidArgumentException;

final class LinkCardCollectionTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'linkCards' => [
                [
                    'body' => 'body 1',
                    'link' => [
                        'name' => 'name 1',
                        'url' => 'url 1',
                    ],
                ],
                [
                    'body' => 'body 2',
                    'link' => [
                        'name' => 'name 2',
                        'url' => 'url 2',
                    ],
                ],
            ],
        ];

        $linkCardCollection = new LinkCardCollection([
            new LinkCard(new Link('name 1', 'url 1'), 'body 1'),
            new LinkCard(new Link('name 2', 'url 2'), 'body 2'),
        ]);

        $this->assertSameWithoutOrder($data['linkCards'], $linkCardCollection['linkCards']);
        $this->assertSame($data, $linkCardCollection->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_at_least_1_link_card()
    {
        $this->expectException(InvalidArgumentException::class);

        new LinkCardCollection([]);
    }

    /**
     * @test
     */
    public function it_only_accepts_link_cards()
    {
        $this->expectException(InvalidArgumentException::class);

        new LinkCardCollection([new Link('name', 'url')]);
    }

    public function viewModelProvider() : array
    {
        return [
            'single' => [new LinkCardCollection([new LinkCard(new Link('name', 'url'), 'body')])],
            'multiple' => [
                new LinkCardCollection([
                    new LinkCard(new Link('name 1', 'url 1'), 'body 1'),
                    new LinkCard(new Link('name 2', 'url 2'), 'body 2'),
                ]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/link-card-collection.mustache';
    }
}
