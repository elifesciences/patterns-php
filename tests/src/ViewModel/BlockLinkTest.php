<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\BlockLink;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Picture;

final class BlockLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'link' => [
                'name' => 'name',
                'url' => 'url'
            ],
            'image' => [
                'fallback' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                ],
            ],
        ];

        $blockLink = new BlockLink(new Link('name', 'url'), new Picture([], new Image($data['image']['fallback']['defaultPath'])));

        $this->assertSame($data['link']['name'], $blockLink['link']['name']);
        $this->assertSame($data['link']['url'], $blockLink['link']['url']);
        $this->assertSame($data['image'], $blockLink['image']->toArray());
        $this->assertSame($data, $blockLink->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'without image' => [new BlockLink(new Link('name', 'url'))],
            'with image' => [new BlockLink(new Link('name', 'url'), new Picture([], new Image('/default/path')))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/block-link.mustache';
    }
}
