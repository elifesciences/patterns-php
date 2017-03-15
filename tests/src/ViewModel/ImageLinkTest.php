<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\ImageLink;
use eLife\Patterns\ViewModel\Picture;

final class ImageLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'url' => 'url',
            'image' => [
                'fallback' => [
                    'classes' => 'image-link__img',
                    'altText' => 'the alt text',
                    'defaultPath' => '/default/path',
                    'srcset' => '/path/to/image/500/wide 500w, /default/path 250w',
                ],
                'pictureClasses' => 'image-link__picture',
            ],
        ];

        $imageLink = new ImageLink('url', new Picture([], new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'], 'the alt text')));

        $this->assertSame($data['url'], $data['url']);
        $this->assertSame($data['image'], $data['image']);
        $this->assertSame($data, $imageLink->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new ImageLink('url', new Picture([], new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'], 'the alt text')))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/image-link.mustache';
    }
}
