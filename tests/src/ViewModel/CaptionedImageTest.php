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
            'caption' => 'caption',
            'picture' => [
                    'fallback' => [
                            'altText' => 'the alt text',
                            'classes' => '',
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
        $captionedImage = new CaptionedImage($data['heading'], $data['caption'], new Picture([
            [
                'srcset' => $data['picture']['sources'][0]['srcset'],
            ],
        ], new Image($data['picture']['fallback']['defaultPath'], [$widthFirst => '/path/to/image/'.$widthFirst.'/wide', $widthSecond => '/default/path'], $data['picture']['fallback']['altText'])));

        $this->assertSame($data, $captionedImage->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new CaptionedImage('heading', 'caption', new Picture([
                    [
                        'srcset' => '/path/to/svg',
                    ],
                ], new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'], 'the alt text'))),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/captioned-image.mustache';
    }
}
