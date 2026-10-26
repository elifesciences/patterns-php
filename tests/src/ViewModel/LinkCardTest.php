<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\LinkCard;
use InvalidArgumentException;

final class LinkCardTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'body' => 'body',
            'link' => [
                'name' => 'name',
                'url' => 'url',
            ],
        ];

        $linkCard = new LinkCard(new Link('name', 'url'), 'body');

        $this->assertSame($data['link']['name'], $linkCard['link']['name']);
        $this->assertSame($data['link']['url'], $linkCard['link']['url']);
        $this->assertSame($data['body'], $linkCard['body']);
        $this->assertSame($data, $linkCard->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_body()
    {
        $this->expectException(InvalidArgumentException::class);

        new LinkCard(new Link('name', 'url'), '');
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new LinkCard(new Link('name', 'url'), 'body')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/link-card.mustache';
    }
}
