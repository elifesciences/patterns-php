<?php

namespace tests\eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ViewModel\PictureSvgWithFallback;

final class PictureSvgWithFallbackTest extends ViewModelTest
{


    /**
     * @test
     */
    public function it_has_data()
    {
        $alt = 'the alt text';
        $defaultImage = 'default/image/path';
        $fallbackSrcset = 'https://example.com/1 500w, https://example.com/2 250w';
        $defaultSvgPath = 'default/svg/path';
        $wideSvgPath = 'svg/path/if/wide';
        $mediaStatement = '(min-width media statement)';

        $basic = new PictureSvgWithFallback($alt, $defaultImage, $fallbackSrcset, [['svg' => $defaultSvgPath]]);
        $this->assertSame($alt, $basic['alt']);
        $this->assertSame($defaultImage, $basic['defaultImage']);
        $this->assertSame($fallbackSrcset, $basic['fallbackSrcset']);
        $this->assertSame($defaultSvgPath, $basic['sources'][0]['svg']);

        $withMedia = new PictureSvgWithFallback($alt, $defaultImage, $fallbackSrcset, [
          [
            'svg' => $wideSvgPath,
            'media' => $mediaStatement,
          ],
          [
            'svg' => $defaultSvgPath,
          ],

        ]);
        $this->assertSame($alt, $withMedia['alt']);
        $this->assertSame($defaultImage, $withMedia['defaultImage']);
        $this->assertSame($fallbackSrcset, $withMedia['fallbackSrcset']);
        $this->assertSame($wideSvgPath, $withMedia['sources'][0]['svg']);
        $this->assertSame($mediaStatement, $withMedia['sources'][0]['media']);
        $this->assertSame($defaultSvgPath, $withMedia['sources'][1]['svg']);
        $this->assertFalse(isset($withMedia['sources'][1]['media']));

    }

    public function viewModelProvider() : array
    {
        return [
          'basic' => [new PictureSvgWithFallback('the alt text', 'default/image/path',
            'https://example.com/1 500w, https://example.com/2 250w',
            [
              [
                'svg' => 'default/svg/path',
              ]
            ]),
          ],
          'with media' => [new PictureSvgWithFallback('the alt text', 'default/image/path',
            'https://example.com/1 500w, https://example.com/2 250w',
            [
              [
                'svg' => 'svg/path/if/wide',
                'media' => 'min-width media statement'
              ],
              [
                'svg' => 'default/svg/path',
              ]
            ]),
          ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/picture-svg-with-fallback.mustache';
    }
}
