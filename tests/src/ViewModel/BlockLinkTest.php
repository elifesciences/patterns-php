<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\BackgroundImage;
use eLife\Patterns\ViewModel\BlockLink;
use eLife\Patterns\ViewModel\Link;

final class BlockLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'text',
            'url' => 'url',
            'behaviour' => 'BackgroundImage',
            'backgroundImage' => [
                'lowResImageSource' => 'lores.jpg',
                'highResImageSource' => 'hires.jpg',
                'thresholdWidth' => 100,
            ],
        ];

        $blockLink = new BlockLink(new Link('text', 'url'), new BackgroundImage('lores.jpg', 'hires.jpg', 100));

        $this->assertSame($data['text'], $data['text']);
        $this->assertSame($data['url'], $data['url']);
        $this->assertSame($data['behaviour'], $data['behaviour']);
        $this->assertSame($data['backgroundImage'], $data['backgroundImage']);
        $this->assertSame($data, $blockLink->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'without image' => [new BlockLink(new Link('text', 'url'))],
            'with image' => [new BlockLink(new Link('text', 'url'), new BackgroundImage('lores.jpg', 'hires.jpg'))],
            'with image and threshold' => [
                new BlockLink(new Link('text', 'url'), new BackgroundImage('lores.jpg', 'hires.jpg', 100)),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/block-link.mustache';
    }
}
