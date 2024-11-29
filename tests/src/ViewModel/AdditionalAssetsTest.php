<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AdditionalAsset;
use eLife\Patterns\ViewModel\AdditionalAssets;
use eLife\Patterns\ViewModel\CaptionText;
use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\DownloadLink;
use eLife\Patterns\ViewModel\Link;

final class AdditionalAssetsTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'heading' => 'Some title',
            'assets' => [
                [
                    'assetId' => 'id',
                    'captionText' => [
                        'heading' => 'heading',
                        'standfirst' => 'standfirst',
                        'text' => 'text',
                    ],
                    'nonDoiLink' => 'http://google.com/',
                    'downloadLink' => [
                        'link' => [
                            'name' => 'download link',
                            'url' => 'http://google.com/download'
                        ],
                        'fileName' => 'file name',
                    ],
                ],
            ],
        ];
        $additionalAssets = new AdditionalAssets(
            $data['heading'],
            [
                AdditionalAsset::withoutDoi(
                    $data['assets'][0]['assetId'],
                    CaptionText::withHeading($data['assets'][0]['captionText']['heading'], $data['assets'][0]['captionText']['standfirst'], $data['assets'][0]['captionText']['text']),
                    DownloadLink::fromLink(
                        new Link($data['assets'][0]['downloadLink']['link']['name'], $data['assets'][0]['downloadLink']['link']['url']),
                        $data['assets'][0]['downloadLink']['fileName']
                    ),
                    $data['assets'][0]['nonDoiLink']
                ),
            ]
        );

        $this->assertSame('Some title', $additionalAssets['heading']);
        $this->assertCount(1, $additionalAssets['assets']);
        $this->assertSame($data['assets'][0], $additionalAssets['assets'][0]->toArray());
        $this->assertSame($data, $additionalAssets->toArray());
    }

    public function viewModelProvider(): array
    {
        $downloadLink = DownloadLink::fromLink(new Link('Download link', 'http://google.com/download'), 'File name');

        return [
            [
                new AdditionalAssets(
                    null,
                    [AdditionalAsset::withDoi('id', CaptionText::withHeading('heading'), $downloadLink, new Doi('10.7554/eLife.10181.001'))]
                ),
            ],
            [
                new AdditionalAssets(
                    'Some title',
                    [AdditionalAsset::withoutDoi('id', CaptionText::withHeading('heading'), $downloadLink, 'http://google.com/')]
                ),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/additional-assets.mustache';
    }
}
