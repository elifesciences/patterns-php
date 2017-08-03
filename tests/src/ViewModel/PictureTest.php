<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\MediaType;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\PictureSource;

final class PictureTest extends ViewModelTest
{
    private $imageFixture;

    public function setUp()
    {
        $this->imageFixture = new Image(
            '/default/path',
            '/path/to/image/500/wide',
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
                'srcset' => '/path/to/image/500/wide 2x',
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

        $picture = new Picture([new PictureSource($data['sources'][0]['srcset']), new PictureSource($data['sources'][1]['srcset'], null, null, $data['sources'][1]['media'])],
            $this->imageFixture, explode(' ', $data['pictureClasses']));
        $this->assertSame($data['fallback']['defaultPath'], $picture['fallback']['defaultPath']);
        $this->assertSame($data['fallback']['altText'], $picture['fallback']['altText']);
        $this->assertSameWithoutOrder($data['sources'], $picture['sources']);
        $this->assertSame($data['pictureClasses'], $picture['pictureClasses']);
        $this->assertSame($data, $picture->toArray());
    }

    public function viewModelProvider() : array
    {
        $image = new Image('/default/path', '/path/to/image/500/wide', 'the alt text');
        $imageWithCssClasses = new Image(
            '/default/path',
            '/path/to/image/500/wide',
            'the alt text',
            ['class-1', 'class-2']
        );

        $sourcesBasic = [
            new PictureSource('/path/to/svg'),
        ];
        $sourcesWithMedia = [
            new PictureSource('/path/to/svg'),
            new PictureSource('/path/to/svg', null, null, 'media statement'),
        ];
        $sourcesWithMediaAndType = [
            new PictureSource('/path/to/svg', null, new MediaType('image/svg+xml')),
            new PictureSource('/path/to/webp', null, new MediaType('image/webp'), 'media statement'),
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
