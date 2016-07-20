<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CaptionedImage;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\ViewerInline;

final class ViewerInlineTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'viewerInline5d870acd',
            'prominentText' => 'REF:',
            'normalText' => '1234',
            'seeAllLink' => '#',
            'downloadLink' => '#',
            'newWindowLink' => '#',
            'captionedImage' => [
                'heading' => 'heading',
                'captions' => [
                    [
                        'caption' => 'caption',
                    ],
                ],
                'picture' => [
                    'fallback' => [
                        'altText' => 'the alt text',
                        'defaultPath' => '/default/path',
                        'srcset' => '/path/to/image/500/wide 500w, /default/path 250w',
                    ],
                    'sources' => [
                        [
                            'srcset' => '/path/to/svg',
                        ],
                    ],
                ],
            ],
        ];

        $viewer = new ViewerInline('REF:', '1234', '#', '#', '#', self::imageStub());

        $this->assertSame($data['id'], $viewer['id']);
        $this->assertSame($data['prominentText'], $viewer['prominentText']);
        $this->assertSame($data['normalText'], $viewer['normalText']);
        $this->assertSame($data['seeAllLink'], $viewer['seeAllLink']);
        $this->assertSame($data['downloadLink'], $viewer['downloadLink']);
        $this->assertSame($data['newWindowLink'], $viewer['newWindowLink']);
        $this->assertSame($data['captionedImage'], $viewer['captionedImage']->toArray());
        $this->assertSame($data, $viewer->toArray());
    }

    public static function imageStub() : CaptionedImage
    {
        return CaptionedImage::withParagraph(
            new Picture(
                [['srcset' => '/path/to/svg']],
                new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'], 'the alt text')
            ),
            'heading',
            'caption'
        );
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new ViewerInline(
                    'REF:', '1234', '#', '#', '#', self::imageStub()
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/viewer-inline.mustache';
    }
}
