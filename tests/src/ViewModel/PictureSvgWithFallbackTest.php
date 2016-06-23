<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\PictureSvgWithFallback;
use InvalidArgumentException;

final class PictureSvgWithFallbackTest extends ViewModelTest
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
              'svg' => '/path/to/svg',
            ],
            [
              'svg' => '/path/to/another/svg',
              'media' => 'media statement',
            ],
          ],
        ];

        $picture = new PictureSvgWithFallback($data['sources'], $this->imageFixture);
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
        new PictureSvgWithFallback([], $this->imageFixture);
    }

    /**
     * @test
     */
    public function it_can_only_have_one_source_without_media_statement()
    {
        $this->expectException(InvalidArgumentException::class);

        $invalidSources = [
          [
            'svg' => '/path/to/svg',
            'media' => null,
          ],
          [
            'svg' => '/path/to/svg',
          ],
          [
            'svg' => '/path/to/svg',
            'media' => 'media statement',
          ],
        ];

        new PictureSvgWithFallback($invalidSources, $this->imageFixture);
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
            'svg' => '/path/to/svg',
          ],
        ];
        $sourcesWithMedia = [
          [
            'svg' => '/path/to/svg',
          ],
          [
            'svg' => '/path/to/svg',
            'media' => 'media statement',
          ],
        ];

        return [
          'basic' => [new PictureSvgWithFallback($sourcesBasic, $image)],
          'has css classes' => [new PictureSvgWithFallback($sourcesBasic, $imageWithCssClasses)],
          'has media statement' => [new PictureSvgWithFallback($sourcesWithMedia, $image)],
          'has css and media statement' => [new PictureSvgWithFallback($sourcesWithMedia, $imageWithCssClasses)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/picture-svg-with-fallback.mustache';
    }
}
