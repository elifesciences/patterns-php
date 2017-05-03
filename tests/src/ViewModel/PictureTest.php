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
            [500 => '/path/to/image/500/wide', 250 => '/default/path'],
            'the alt text',
            ['class-1', 'class-2']);
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
                'srcset' => '/path/to/image/500/wide 500w, /default/path 250w',
                'classes' => 'class-1 class-2',
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
            'pictureClasses' => 'class-3',
        ];

        $picture = new Picture($data['sources'], $this->imageFixture, explode(' ', $data['pictureClasses']));
        $this->assertSame($data['fallback']['defaultPath'], $picture['fallback']['defaultPath']);
        $this->assertSame($data['fallback']['altText'], $picture['fallback']['altText']);
        $this->assertSame($data['sources'], $picture['sources']);
        $this->assertSame($data['pictureClasses'], $picture['pictureClasses']);
        $this->assertSame($data, $picture->toArray());
    }

    public function viewModelProvider() : array
    {
        $image = new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'], 'the alt text');
        $imageWithCssClasses = new Image(
            '/default/path',
            [500 => '/path/to/image/500/wide', 250 => '/default/path'],
            'the alt text',
            ['class-1', 'class-2']
        );

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
            'has css classes' => [new Picture($sourcesBasic, $imageWithCssClasses, ['class', 'another class'])],
            'has media statement' => [new Picture($sourcesWithMedia, $image)],
            'has media statement and type' => [new Picture($sourcesWithMediaAndType, $image)],
            'has css and media statement' => [new Picture($sourcesWithMedia, $imageWithCssClasses)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/picture.mustache';
    }
}
