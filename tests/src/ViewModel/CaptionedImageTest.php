<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CaptionedImage;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;

final class CaptionedImageTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $widthFirst = 500;
        $widthSecond = 250;
        $data = [
            'heading' => 'heading',
            'captions' => [
                ['caption' => 'the first caption'],
            ],
            'picture' => [
                'fallback' => [
                    'altText' => 'the alt text',
                    'defaultPath' => '/default/path',
                    'srcset' => '/path/to/image/'.$widthFirst.'/wide '.$widthFirst.'w, /default/path '.$widthSecond.'w',
                ],
                'sources' => [
                    [
                        'srcset' => '/path/to/svg',
                    ],
                ],
            ],
        ];
        $captionedImage = CaptionedImage::withParagraph(
            new Picture(
                [['srcset' => $data['picture']['sources'][0]['srcset']]],
                new Image(
                    $data['picture']['fallback']['defaultPath'],
                    [$widthFirst => '/path/to/image/'.$widthFirst.'/wide', $widthSecond => '/default/path'],
                    $data['picture']['fallback']['altText']
                )
            ),
            $data['heading'],
            $data['captions'][0]['caption']
        );

        $this->assertSame($data, $captionedImage->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'Captioned image with custom content' => [
                CaptionedImage::withCustomContent(
                    new Picture(
                        [['srcset' => '/path/to/svg']],
                        new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'],
                            'the alt text')
                    ),
                    '<b>Custom content</b>'),
            ],
            'Captioned image with multiple paragraphs' => [
                CaptionedImage::withParagraphs(
                    new Picture(
                        [['srcset' => '/path/to/svg']],
                        new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'],
                            'the alt text')
                    ),
                    'heading',
                    ['my first caption', 'my second caption']
                ),
            ],
            'Captioned image with single paragraph' => [
                CaptionedImage::withParagraph(
                    new Picture(
                        [['srcset' => '/path/to/svg']],
                        new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'],
                            'the alt text')
                    ),
                    'heading',
                    'caption'
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/captioned-image.mustache';
    }
}
