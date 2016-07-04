<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;
use InvalidArgumentException;

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
            'classes' => 'class-1 class-2',
            'defaultPath' => '/default/path',
            'srcset' => '/path/to/image/500/wide 500w, /default/path 250w',
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
        $this->assertSame($data['fallback']['classes'], $picture['fallback']['classes']);
        $this->assertSame($data['sources'], $picture['sources']);
        $this->assertSame($data, $picture->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_at_least_one_source()
    {
        $this->expectException(InvalidArgumentException::class);
        new Picture([], $this->imageFixture);
    }

    /**
     * @test
     */
    public function it_can_only_have_one_source_without_media_statement()
    {
        $this->expectException(InvalidArgumentException::class);

        $invalidSources = [
          [
            'srcset' => '/path/to/svg',
            'media' => null,
          ],
          [
            'srcset' => '/path/to/svg',
          ],
          [
            'srcset' => '/path/to/svg',
            'media' => 'media statement',
          ],
        ];

        new Picture($invalidSources, $this->imageFixture);
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
          'basic' => [new Picture($sourcesBasic, $image)],
          'has css classes' => [new Picture($sourcesBasic, $imageWithCssClasses)],
          'has media statement' => [new Picture($sourcesWithMedia, $image)],
          'has media statement and type' => [new Picture($sourcesWithMediaAndType, $image)],
          'has css and media statement' => [new Picture($sourcesWithMedia, $imageWithCssClasses)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/picture.mustache';
    }
}
