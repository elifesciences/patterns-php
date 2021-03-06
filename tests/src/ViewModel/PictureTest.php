<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;

final class PictureTest extends ViewModelTest
{
    private $imageFixture;

    public function setUp()
    {
        $this->imageFixture = new Image(
            '/default/path',
            ['2' => '/path/to/image/500/wide', '1' => '/default/path'],
            'the alt text');
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'fallback' => [
                'altText' => 'the alt text',
                'defaultPath' => '/default/path',
                'srcset' => '/path/to/image/500/wide 2x, /default/path 1x',
            ],
            'sources' => [
                [
                    'srcset' => '/path/to/svg',
                ],
                [
                    'srcset' => '/path/to/another/svg',
                    'media' => 'media statement',
                ],
            ],
        ];

        $picture = new Picture($data['sources'], $this->imageFixture);
        $this->assertSame($data['fallback']['defaultPath'], $picture['fallback']['defaultPath']);
        $this->assertSame($data['fallback']['altText'], $picture['fallback']['altText']);
        $this->assertSame($data['sources'], $picture['sources']);
        $this->assertSame($data, $picture->toArray());
    }

    public function viewModelProvider() : array
    {
        $image = new Image('/default/path', ['2' => '/path/to/image/500/wide', '1' => '/default/path'], 'the alt text');

        $sourcesBasic = [
            [
                'srcset' => '/path/to/svg',
            ],
        ];
        $sourcesWithMedia = [
            [
                'srcset' => '/path/to/svg',
            ],
            [
                'srcset' => '/path/to/svg',
                'media' => 'media statement',
            ],
        ];
        $sourcesWithMediaAndType = [
            [
                'srcset' => '/path/to/svg',
                'type' => 'image/svg+xml',
            ],
            [
                'srcset' => '/path/to/webp',
                'media' => 'media statement',
                'type' => 'image/webp',
            ],
        ];

        return [
            'no sources' => [new Picture([], $image)],
            'basic' => [new Picture($sourcesBasic, $image)],
            'has media statement' => [new Picture($sourcesWithMedia, $image)],
            'has media statement and type' => [new Picture($sourcesWithMediaAndType, $image)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/picture.mustache';
    }
}
