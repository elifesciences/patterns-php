<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CaptionedAsset;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\MediaSource;
use eLife\Patterns\ViewModel\MediaType;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\Table;
use eLife\Patterns\ViewModel\Video;

final class CaptionedAssetTest extends ViewModelTest
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
        $captionedImage = CaptionedAsset::withParagraph(
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

        $widthFirst = 500;
        $widthSecond = 250;
        $data = [
            'heading' => 'heading',
            'captions' => [
                ['caption' => 'the first caption'],
            ],
            'image' => [
                'altText' => 'the alt text',
                'defaultPath' => '/default/path',
                'srcset' => '/path/to/image/'.$widthFirst.'/wide '.$widthFirst.'w, /default/path '.$widthSecond.'w',
            ],
        ];
        $captionedImage = CaptionedAsset::withParagraph(
            new Image(
                $data['image']['defaultPath'],
                [$widthFirst => '/path/to/image/'.$widthFirst.'/wide', $widthSecond => '/default/path'],
                $data['image']['altText']
            ),
            $data['heading'],
            $data['captions'][0]['caption']
        );

        $this->assertSame($data, $captionedImage->toArray());

        $data = [
            'customContent' => '<h3>This is custom content</h3><ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>',
            'table' => '<table><thead><tr><th>F(Dfn, Dfd)</th><th>Partial η<sup>2</sup></th><th>Original effect size <em>f</em></th><th>Replication total sample size</th><th>Detectable effect size <em>f</em></th></tr></thead><tbody><tr><td>F(24,39) = 0.8678 (interaction)</td><td>0.348120</td><td>0.7307699</td><td>169<a class="xref-table-fn" href="#tblfn2">*</a></td><td>0.3895070<a class="xref-table-fn" href="#tblfn3">†</a></td></tr><tr><td>F(2,39) = 0.8075 (treatments)</td><td>0.039766</td><td>0.2035014</td><td>169<a class="xref-table-fn" href="#tblfn2">*</a></td><td>0.2415459<a class="xref-table-fn" href="#tblfn3">†</a></td></tr><tr><td>F(12,39) = 187.6811 (hematology parameters)</td><td>0.982978</td><td>7.599178</td><td>169<a class="xref-table-fn" href="#tblfn2">*</a></td><td>0.3331365<a class="xref-table-fn" href="#tblfn4">‡</a></td></tr></tbody></table>',
        ];

        $figure = CaptionedAsset::withCustomContent(new Table($data['table']), $data['customContent']);
        $this->assertSameWithoutOrder($data, $figure->toArray());
    }

    public function test_it_works_with_latest_json()
    {
    }

    public function viewModelProvider() : array
    {
        return [
            'Captioned image with custom content' => [
                CaptionedAsset::withCustomContent(
                    new Picture(
                        [['srcset' => '/path/to/svg']],
                        new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'],
                            'the alt text')
                    ),
                    '<b>Custom content</b>'),
            ],
            'Captioned image with multiple paragraphs' => [
                CaptionedAsset::withParagraphs(
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
                CaptionedAsset::withParagraph(
                    new Picture(
                        [['srcset' => '/path/to/svg']],
                        new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'],
                            'the alt text')
                    ),
                    'heading',
                    'caption'
                ),
            ],
            'Captioned image with only heading' => [
                CaptionedAsset::withOnlyHeading(
                    new Picture(
                        [['srcset' => '/path/to/svg']],
                        new Image('/default/path', [500 => '/path/to/image/500/wide', 250 => '/default/path'],
                            'the alt text')
                    ),
                    'heading'
                ),
            ],
            'Captioned table with custom content' => [
                CaptionedAsset::withCustomContent(
                    new Table(
                        '<table><thead><tr><th>F(Dfn, Dfd)</th><th>Partial η<sup>2</sup></th><th>Original effect size <em>f</em></th><th>Replication total sample size</th><th>Detectable effect size <em>f</em></th></tr></thead><tbody><tr><td>F(24,39) = 0.8678 (interaction)</td><td>0.348120</td><td>0.7307699</td><td>169<a class="xref-table-fn" href="#tblfn2">*</a></td><td>0.3895070<a class="xref-table-fn" href="#tblfn3">†</a></td></tr><tr><td>F(2,39) = 0.8075 (treatments)</td><td>0.039766</td><td>0.2035014</td><td>169<a class="xref-table-fn" href="#tblfn2">*</a></td><td>0.2415459<a class="xref-table-fn" href="#tblfn3">†</a></td></tr><tr><td>F(12,39) = 187.6811 (hematology parameters)</td><td>0.982978</td><td>7.599178</td><td>169<a class="xref-table-fn" href="#tblfn2">*</a></td><td>0.3331365<a class="xref-table-fn" href="#tblfn4">‡</a></td></tr></tbody></table>'
                    ),
                    '<h3>This is custom content</h3><ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>'
                ),
            ],
            'Captioned video with custom content' => [
                CaptionedAsset::withCustomContent(
                    new Video('http://some.image.com/test.jpg',
                        [new MediaSource('/file.mp4', new MediaType('video/mp4'))]),
                    '<h3>This is custom content</h3><ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>'
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/captioned-asset.mustache';
    }
}
